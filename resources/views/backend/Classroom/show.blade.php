<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VR Classroom - {{ $classroom->room_name }}</title>

    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>

    <script>
    // 🛡️ ক্যামেরা-লেভেল ভার্চুয়াল ফেন্স (১০০% গ্যারান্টিড লক)
    AFRAME.registerComponent('camera-fence', {
        schema: {
            minX: {type: 'number', default: -15},
            maxX: {type: 'number', default: 15},
            minZ: {type: 'number', default: -15},
            maxZ: {type: 'number', default: 15},
            minY: {type: 'number', default: 0.2},
            maxY: {type: 'number', default: 5}
        },
        tick: function () {
            // সরাসরি মেইন ক্যামেরার পজিশন ট্র্যাক করা হচ্ছে
            let cameraEl = document.querySelector('[camera]');
            if (!cameraEl) return;

            let currentPos = cameraEl.getAttribute('position');
            let data = this.data;
            let newPos = { x: currentPos.x, y: currentPos.y, z: currentPos.z };
            let changed = false;

            // ক্যামেরার নিজস্ব এক্সিলারেটেড পজিশন চেক ও লক
            if (currentPos.x < data.minX) { newPos.x = data.minX; changed = true; }
            if (currentPos.x > data.maxX) { newPos.x = data.maxX; changed = true; }
            if (currentPos.y < data.minY) { newPos.y = data.minY; changed = true; }
            if (currentPos.y > data.maxY) { newPos.y = data.maxY; changed = true; }
            if (currentPos.z < data.minZ) { newPos.z = data.minZ; changed = true; }
            if (currentPos.z > data.maxZ) { newPos.z = data.maxZ; changed = true; }

            // যদি ক্যামেরা বর্ডার ক্রস করতে চায়, তাকে জোরপূর্বক আটকে দাও
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

        <a-assets>
            <a-asset-item id="classroom-structure" src="{{ asset($classroom->vr_model_path) }}"></a-asset-item>
        </a-assets>

        <a-gltf-model src="#classroom-structure" position="0 0 0" scale="1 1 1"></a-gltf-model>

        <a-sky color="#A3D1FF"></a-sky>

        <a-entity id="rig" position="0 0 0" camera-fence="minX: -10; maxX: 1; minZ: -8; maxZ: 0; minY: 0.2; maxY: 5">
            <a-entity camera
                      look-controls="pointerLockEnabled: false"
                      wasd-controls="acceleration: 20"
                      position="0 1.6 0">
            </a-entity>
        </a-entity>

    </a-scene>

</body>
</html>
