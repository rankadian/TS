document.addEventListener('DOMContentLoaded', () => {
    // 1. Setup Scene
    const scene = new THREE.Scene();
    scene.background = null;

    // 2. Kamera dengan posisi yang lebih tinggi
    const camera = new THREE.PerspectiveCamera(45, 700/700, 0.1, 1000);
    camera.position.set(0, 2.2, 7); // Naikkan posisi Y kamera

    // 3. Renderer
    const renderer = new THREE.WebGLRenderer({ 
        antialias: true, 
        alpha: true,
        powerPreference: "high-performance"
    });
    const viewer = document.getElementById('viewer');
    renderer.setSize(viewer.clientWidth, viewer.clientHeight);
    viewer.appendChild(renderer.domElement);

    // 4. Orbit Controls
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.enableZoom = true;
    controls.enablePan = false;
    controls.maxPolarAngle = Math.PI * 0.5;

    // 5. Pencahayaan
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
    scene.add(ambientLight);
    
    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 10, 7.5);
    scene.add(directionalLight);

    // Variabel untuk animasi
    let mixer, clock = new THREE.Clock();
    let robot, eyes = null;
    let eyesInitialPosition = new THREE.Vector3();
    let head = null;

    // 6. Load Model GLB
    const loader = new THREE.GLTFLoader();
    loader.load(
        'futuristic_flying_animated_robot_-_low_poly.glb',
        (gltf) => {
            robot = gltf.scene;
            
            // Skala dan posisi yang sudah disesuaikan
            robot.scale.set(6.5, 6.5, 6.5); // Sedikit diperkecil
            robot.position.set(0, -1.9, 0); // Posisi Y disesuaikan ke atas
            robot.rotation.set(0, Math.PI, 0);
            scene.add(robot);

            // Cari bagian mata dan kepala
            robot.traverse(child => {
                if (child.name.includes('Eye') || child.name.includes('eye')) {
                    eyes = child;
                    eyesInitialPosition.copy(child.position);
                    console.log('Mata ditemukan:', child.name);
                }
                if (child.name.toLowerCase().includes('head')) {
                    head = child;
                }
            });

            // Setup animasi model
            mixer = new THREE.AnimationMixer(robot);
            if (gltf.animations && gltf.animations.length > 0) {
                const action = mixer.clipAction(gltf.animations[0]);
                action.clampWhenFinished = true;
                action.loop = THREE.LoopRepeat;
                action.play();
                robot.userData.animation = action;
            }

            // Mouse tracking untuk mata (diperhalus)
            viewer.addEventListener('mousemove', (event) => {
                const rect = viewer.getBoundingClientRect();
                const mouseX = ((event.clientX - rect.left) / viewer.clientWidth) * 2 - 1;
                const mouseY = -((event.clientY - rect.top) / viewer.clientHeight) * 2 + 1;

                if (eyes) {
                    const maxOffset = 0.25; // Gerakan lebih halus
                    const smoothFactor = 0.1; // Faktor smoothing
                    
                    const targetX = eyesInitialPosition.x + (mouseX * maxOffset);
                    const targetZ = eyesInitialPosition.z + (mouseY * maxOffset * 0.5);
                    
                    eyes.position.x += (targetX - eyes.position.x) * smoothFactor;
                    eyes.position.z += (targetZ - eyes.position.z) * smoothFactor;
                }

                // Gerakkan kepala sedikit mengikuti mouse
                if (head) {
                    head.rotation.y = mouseX * 0.08; // Lebih halus
                    head.rotation.x = mouseY * 0.04;
                }
            });

            // Klik untuk trigger animasi
            viewer.addEventListener('click', (event) => {
                if (robot?.userData?.animation) {
                    robot.userData.animation.reset().play();
                }
            });
        },
        undefined,
        (error) => {
            console.error('Error loading model:', error);
            viewer.innerHTML = '<div style="color:red;padding:20px;text-align:center;">GAGAL LOAD MODEL 3D<br>Periksa console untuk detail</div>';
        }
    );

    // Animation loop
    const animate = () => {
        requestAnimationFrame(animate);
        const delta = clock.getDelta();
        if (mixer) mixer.update(delta);
        controls.update();
        renderer.render(scene, camera);
    };
    animate();

    // Handle resize
    window.addEventListener('resize', () => {
        camera.aspect = viewer.clientWidth / viewer.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(viewer.clientWidth, viewer.clientHeight);
    });
});