<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VR Classroom - {{ $classroom->room_name }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>

    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <script>
    // 🛡️ ক্যামেরা-লেভেল ভার্চুয়াল ফেন্স (রিগ পজিশন সিঙ্ক সহ ফিক্সড)
    AFRAME.registerComponent('camera-fence', {
        schema: {
            minX: {type: 'number', default: -10},
            maxX: {type: 'number', default: 1},
            minZ: {type: 'number', default: -8},
            maxZ: {type: 'number', default: 0},
            minY: {type: 'number', default: 0.2},
            maxY: {type: 'number', default: 5}
        },
        tick: function () {
            let cameraEl = document.getElementById('local-camera');
            if (!cameraEl) return;

            let currentPos = cameraEl.getAttribute('position');
            let data = this.data;
            let newPos = { x: currentPos.x, y: currentPos.y, z: currentPos.z };
            let changed = false;

            if (currentPos.x < data.minX) { newPos.x = data.minX; changed = true; }
            if (currentPos.x > data.maxX) { newPos.x = data.maxX; changed = true; }
            if (currentPos.z < data.minZ) { newPos.z = data.minZ; changed = true; }
            if (currentPos.z > data.maxZ) { newPos.z = data.maxZ; changed = true; }

            if (changed) {
                cameraEl.setAttribute('position', newPos);
            }
        }
    });
    </script>

    <style>
        .back-btn {
            position: absolute; top: 20px; left: 20px; z-index: 9999;
            background: rgba(0, 0, 0, 0.7); color: white; padding: 10px 20px;
            border-radius: 5px; text-decoration: none; font-family: sans-serif;
            font-weight: bold; border: 1px solid #fff;
        }
        .back-btn:hover { background: #000; }
    </style>
</head>
<body>

    <a href="{{ route('classrooms.index') }}" class="back-btn">⬅ Leave VR Class</a>

    <a-scene embedded style="height: 100vh; width: 100%;">

        <a-assets timeout="10000">
            <a-asset-item id="classroom-structure" src="{{ asset($classroom->vr_model_path) }}"></a-asset-item>
        </a-assets>

        <a-gltf-model src="#classroom-structure" position="0 0 0" scale="1 1 1"></a-gltf-model>

        <a-sky color="#A3D1FF"></a-sky>

        <a-entity id="rig" position="0 0 0">
            <a-entity camera id="local-camera"
                      camera-fence
                      look-controls="pointerLockEnabled: false"
                      wasd-controls="acceleration: 20"
                      position="0 1.6 0">
            </a-entity>
        </a-entity>

        <a-entity id="remote-players"></a-entity>

    </a-scene>

    <script>
        const classroomId = "{{ $classroom->id }}";
        const currentUserId = "{{ auth()->user()->id }}";
        const currentUserName = "{{ auth()->user()->name }}";

        // ১. Laravel Echo কনফিগারেশন
        window.Echo = new window.Echo({
            broadcaster: 'reverb',
            key: "{{ config('reverb.apps.apps.0.key') }}" || 'vfyh007ihftdwgkcwt4a',
            wsHost: '127.0.0.1',
            wsPort: 8080,
            wssPort: 8080,
            forceTLS: false,
            debug: true,
            enabledTransports: ['ws', 'wss'],
            authEndpoint: window.location.origin + '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        });

        const remotePlayersContainer = document.getElementById('remote-players');

        let classroomChannel = null;
        // ২. Presence Channel-এ জয়েন ও লিসেন করা
        classroomChannel = window.Echo.join(`classroom.${classroomId}`)
            .here((users) => {
                users.forEach(user => {
                    if (user.id != currentUserId) {
                        createPlayerAvatar(user.id, user.name);
                    }
                });
            })
            .joining((user) => {
                createPlayerAvatar(user.id, user.name);
            })
            .leaving((user) => {
                const avatar = document.getElementById(`player-${user.id}`);
                if (avatar) avatar.remove();
            })
            let targetPositions = {}; // অন্য প্লেয়ারদের টার্গেট পজিশন রাখার জন্য

            classroomChannel.listen('.player.moved', (data) => {
                const avatar = document.getElementById(`player-${data.playerId}`);
                if (avatar && data.position) {
                    const coords = data.position.split(' ');
                    const rots = data.rotation ? data.rotation.split(' ') : ['0', '0', '0'];

                    // ⚡ ডিরেক্ট সেট না করে গন্তব্য লিখে রাখছি
                    targetPositions[data.playerId] = {
                        x: parseFloat(coords[0]),
                        y: 0.75,
                        z: parseFloat(coords[2]),
                        rotY: parseFloat(rots[1])
                    };
                }
            });

            // ⚡ এ-ফ্রেমের প্রতি ফ্রেমে বক্সগুলোকে স্মুথলি টেনে নতুন পজিশনে নেওয়া (Lerp)
            AFRAME.registerComponent('smooth-mover', {
                tick: function () {
                    for (let id in targetPositions) {
                        const avatar = document.getElementById(`player-${id}`);
                        if (avatar && avatar.object3D) {
                            const target = targetPositions[id];

                            // 🏃‍♂️ কারেন্ট পজিশন থেকে টার্গেট পজিশনের দিকে ১০% করে আগাবে (স্মুথ গ্লাইড)
                            avatar.object3D.position.x += (target.x - avatar.object3D.position.x) * 0.15;
                            avatar.object3D.position.z += (target.z - avatar.object3D.position.z) * 0.15;

                            // রোটেশন স্মুথ করা
                            const currentRotRad = avatar.object3D.rotation.y;
                            const targetRotRad = THREE.MathUtils.degToRad(target.rotY);
                            avatar.object3D.rotation.y += (targetRotRad - currentRotRad) * 0.2;
                        }
                    }
                }
            });
            // এই কম্পোনেন্টটা সিন-এ লাগিয়ে দেওয়া
            document.querySelector('a-scene').setAttribute('smooth-mover', '');

        // ৩. ৩ডি অ্যাভাটার বানানোর ফাংশন
        function createPlayerAvatar(id, name) {
            if (document.getElementById(`player-${id}`)) return;

            console.log("Creating avatar:", id, name);
            const remotePlayersContainer = document.getElementById('remote-players');
            const avatar = document.createElement('a-box');
            avatar.setAttribute('id', `player-${id}`);
            avatar.setAttribute('color', 'red');
            avatar.setAttribute('width', '0.5');
            avatar.setAttribute('height', '1.5');
            avatar.setAttribute('depth', '0.5');
            avatar.setAttribute('position', '0 0.75 0');

            const textEntity = document.createElement('a-text');
            textEntity.setAttribute('value', name);
            textEntity.setAttribute('align', 'center');
            textEntity.setAttribute('position', '0 1 0');
            textEntity.setAttribute('scale', '0.5 0.5 0.5');
            avatar.appendChild(textEntity);

            remotePlayersContainer.appendChild(avatar);
        }

        // ৪. লাইভ পজিশন ব্রডকাস্ট লুপ (এখন ব্যাকএন্ড রাউটে হিট করবে)
        let lastPosition = { x: 0, y: 0, z: 0 };
        let lastRotation = { x: 0, y: 0, z: 0 };

        setInterval(() => {
            const liveCamera = document.getElementById('local-camera');

            if (liveCamera) {
                const currentPos = liveCamera.getAttribute('position');
                const currentRot = liveCamera.getAttribute('rotation');

                if (currentPos && currentRot) {
                    const hasMoved =
                        Math.abs(currentPos.x - lastPosition.x) > 0.01 ||
                        Math.abs(currentPos.z - lastPosition.z) > 0.01 ||
                        Math.abs(currentRot.y - lastRotation.y) > 0.1;

                    if (hasMoved) {
                        // এপিআই-তে ডাটা পোস্ট করার মেকানিজম
                        fetch('/api/classroom/move', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                classroomId: classroomId,
                                playerId: currentUserId,
                                position: `${currentPos.x.toFixed(3)} ${currentPos.y.toFixed(3)} ${currentPos.z.toFixed(3)}`,
                                rotation: `${currentRot.x.toFixed(1)} ${currentRot.y.toFixed(1)} ${currentRot.z.toFixed(1)}`
                            })
                        });

                        lastPosition = { x: currentPos.x, y: currentPos.y, z: currentPos.z };
                        lastRotation = { x: currentRot.x, y: currentRot.y, z: currentRot.z };
                    }
                }
            }
        }, 300);
    </script>
</body>
</html>
