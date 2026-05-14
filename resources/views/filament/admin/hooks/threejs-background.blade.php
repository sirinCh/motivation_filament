<div id="motivflow-three-bg" style="position:fixed;top:0;left:0;width:100%;height:100%;z-index:0;pointer-events:none;" wire:ignore></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
(function() {
    const container = document.getElementById('motivflow-three-bg');
    if (!container) return;

    // --- Detection mode léger ---
    const isLightMode = (
        (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4) ||
        window.innerWidth < 768 ||
        matchMedia('(prefers-reduced-motion: reduce)').matches
    );

    const PARTICLE_COUNT = isLightMode ? 500 : 1500;
    const SHAPE_COUNT = isLightMode ? 10 : 25;
    const ENABLE_TORUS = !isLightMode;
    const ENABLE_PARALLAX = !isLightMode;

    // --- Setup renderer ---
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: !isLightMode });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, isLightMode ? 1 : 2));
    renderer.domElement.style.width = '100%';
    renderer.domElement.style.height = '100%';
    renderer.domElement.style.display = 'block';
    container.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 30;

    // --- Palette ---
    const palette = [
        new THREE.Color(0x6c5ce7),
        new THREE.Color(0xa29bfe),
        new THREE.Color(0xfd79a8),
        new THREE.Color(0x00cec9),
        new THREE.Color(0xfdcb6e)
    ];

    // --- Particles ---
    const positions = new Float32Array(PARTICLE_COUNT * 3);
    const colors = new Float32Array(PARTICLE_COUNT * 3);
    const sizes = new Float32Array(PARTICLE_COUNT);

    for (let i = 0; i < PARTICLE_COUNT; i++) {
        positions[i * 3] = (Math.random() - 0.5) * 60;
        positions[i * 3 + 1] = (Math.random() - 0.5) * 60;
        positions[i * 3 + 2] = (Math.random() - 0.5) * 60;
        const c = palette[Math.floor(Math.random() * palette.length)];
        colors[i * 3] = c.r;
        colors[i * 3 + 1] = c.g;
        colors[i * 3 + 2] = c.b;
        sizes[i] = Math.random() * 2 + 0.5;
    }

    const particlesGeometry = new THREE.BufferGeometry();
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particlesGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    particlesGeometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

    const particlesMaterial = new THREE.PointsMaterial({
        size: 0.15,
        vertexColors: true,
        transparent: true,
        opacity: 0.6,
        blending: THREE.AdditiveBlending,
        sizeAttenuation: true
    });

    const particles = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particles);

    // --- Floating geometric shapes ---
    const shapes = [];
    const geometries = [
        new THREE.IcosahedronGeometry(1, 0),
        new THREE.OctahedronGeometry(0.8, 0),
        new THREE.TetrahedronGeometry(0.7, 0),
        new THREE.BoxGeometry(0.6, 0.6, 0.6)
    ];

    for (let i = 0; i < SHAPE_COUNT; i++) {
        const geo = geometries[Math.floor(Math.random() * geometries.length)];
        const mat = new THREE.MeshBasicMaterial({
            color: palette[Math.floor(Math.random() * palette.length)],
            wireframe: true,
            transparent: true,
            opacity: 0.15
        });
        const mesh = new THREE.Mesh(geo, mat);
        mesh.position.set(
            (Math.random() - 0.5) * 40,
            (Math.random() - 0.5) * 40,
            (Math.random() - 0.5) * 20
        );
        mesh.userData = {
            rotSpeed: { x: (Math.random() - 0.5) * 0.02, y: (Math.random() - 0.5) * 0.02 },
            floatSpeed: Math.random() * 0.005 + 0.002,
            floatOffset: Math.random() * Math.PI * 2
        };
        shapes.push(mesh);
        scene.add(mesh);
    }

    // --- Torus knot (mode normal uniquement) ---
    let torusKnot = null;
    if (ENABLE_TORUS) {
        torusKnot = new THREE.Mesh(
            new THREE.TorusKnotGeometry(3, 0.8, 100, 16),
            new THREE.MeshBasicMaterial({
                color: 0x6c5ce7,
                wireframe: true,
                transparent: true,
                opacity: 0.08
            })
        );
        torusKnot.position.set(15, 0, -10);
        scene.add(torusKnot);
    }

    // --- Mouse interaction ---
    let mouseX = 0, mouseY = 0;
    if (ENABLE_PARALLAX) {
        document.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
            mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
        });
    }

    // --- Animation loop ---
    function animate() {
        requestAnimationFrame(animate);
        const time = Date.now() * 0.001;

        particles.rotation.y += 0.0003;
        particles.rotation.x += 0.0001;

        if (ENABLE_PARALLAX) {
            camera.position.x += (mouseX * 3 - camera.position.x) * 0.02;
            camera.position.y += (-mouseY * 3 - camera.position.y) * 0.02;
        }
        camera.lookAt(scene.position);

        shapes.forEach(s => {
            s.rotation.x += s.userData.rotSpeed.x;
            s.rotation.y += s.userData.rotSpeed.y;
            s.position.y += Math.sin(time * s.userData.floatSpeed * 100 + s.userData.floatOffset) * 0.01;
        });

        if (torusKnot) {
            torusKnot.rotation.x += 0.005;
            torusKnot.rotation.y += 0.003;
        }

        renderer.render(scene, camera);
    }
    animate();

    // --- Resize handler ---
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
})();
</script>
