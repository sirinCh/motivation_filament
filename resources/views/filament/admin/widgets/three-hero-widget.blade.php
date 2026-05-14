<x-filament-widgets::widget>
    <div class="relative w-full h-48 rounded-2xl overflow-hidden border border-white/10 bg-black/20" wire:ignore>
        <canvas id="hero-three-canvas" class="absolute inset-0 w-full h-full"></canvas>

        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="text-center">
                <h2 class="text-2xl font-black text-white/90 mb-1 drop-shadow-lg">
                    ⚡ MotivFlow
                </h2>
                <p class="text-sm text-white/60 drop-shadow-md">Productivité & Motivation</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        (function() {
            const canvas = document.getElementById('hero-three-canvas');
            if (!canvas) return;

            const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
            renderer.setSize(canvas.parentElement.offsetWidth, canvas.parentElement.offsetHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, canvas.parentElement.offsetWidth / canvas.parentElement.offsetHeight, 0.1, 100);
            camera.position.z = 25;

            // Particles
            const count = 600;
            const positions = new Float32Array(count * 3);
            const colors = new Float32Array(count * 3);
            const palette = [
                new THREE.Color(0x6c5ce7),
                new THREE.Color(0xa29bfe),
                new THREE.Color(0xfd79a8),
                new THREE.Color(0x00cec9),
            ];

            for (let i = 0; i < count; i++) {
                positions[i*3] = (Math.random() - 0.5) * 40;
                positions[i*3+1] = (Math.random() - 0.5) * 20;
                positions[i*3+2] = (Math.random() - 0.5) * 20;
                const c = palette[Math.floor(Math.random() * palette.length)];
                colors[i*3] = c.r;
                colors[i*3+1] = c.g;
                colors[i*3+2] = c.b;
            }

            const geo = new THREE.BufferGeometry();
            geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            geo.setAttribute('color', new THREE.BufferAttribute(colors, 3));

            const mat = new THREE.PointsMaterial({
                size: 0.15,
                vertexColors: true,
                transparent: true,
                opacity: 0.6,
                blending: THREE.AdditiveBlending,
            });

            const particles = new THREE.Points(geo, mat);
            scene.add(particles);

            // Floating shapes
            const shapes = [];
            const geometries = [
                new THREE.IcosahedronGeometry(0.8, 0),
                new THREE.OctahedronGeometry(0.6, 0),
                new THREE.TetrahedronGeometry(0.5, 0),
            ];

            for (let i = 0; i < 8; i++) {
                const g = geometries[Math.floor(Math.random() * geometries.length)];
                const m = new THREE.MeshBasicMaterial({
                    color: palette[Math.floor(Math.random() * palette.length)],
                    wireframe: true,
                    transparent: true,
                    opacity: 0.12,
                });
                const mesh = new THREE.Mesh(g, m);
                mesh.position.set((Math.random()-0.5)*30, (Math.random()-0.5)*15, (Math.random()-0.5)*10);
                mesh.userData = {
                    rx: (Math.random()-0.5)*0.02,
                    ry: (Math.random()-0.5)*0.02,
                };
                shapes.push(mesh);
                scene.add(mesh);
            }

            function animate() {
                requestAnimationFrame(animate);
                particles.rotation.y += 0.0005;
                particles.rotation.x += 0.0002;
                shapes.forEach(s => {
                    s.rotation.x += s.userData.rx;
                    s.rotation.y += s.userData.ry;
                });
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                const w = canvas.parentElement.offsetWidth;
                const h = canvas.parentElement.offsetHeight;
                renderer.setSize(w, h);
                camera.aspect = w / h;
                camera.updateProjectionMatrix();
            });
        })();
    </script>
</x-filament-widgets::widget>
