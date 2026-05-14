<!-- Confetti Overlay — Global API: window.MotivConfetti.launch() -->
<canvas id="motivflow-confetti-canvas" style="position:fixed;top:0;left:0;width:100%;height:100%;z-index:9999;pointer-events:none;" wire:ignore></canvas>

<script>
(function() {
    const canvas = document.getElementById('motivflow-confetti-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = window.innerWidth;
    let height = window.innerHeight;
    canvas.width = width;
    canvas.height = height;

    let pieces = [];
    let isActive = false;
    let animId = null;

    const palette = ['#6c5ce7','#a29bfe','#fd79a8','#00cec9','#fdcb6e','#00b894','#e74c3c','#f39c12'];

    function launch() {
        pieces = [];
        isActive = true;
        for (let i = 0; i < 200; i++) {
            pieces.push({
                x: Math.random() * width,
                y: Math.random() * height - height,
                w: Math.random() * 10 + 5,
                h: Math.random() * 6 + 3,
                color: palette[Math.floor(Math.random() * palette.length)],
                vx: (Math.random() - 0.5) * 4,
                vy: Math.random() * 3 + 2,
                rotation: Math.random() * 360,
                rotSpeed: (Math.random() - 0.5) * 10,
                opacity: 1
            });
        }
        if (animId) cancelAnimationFrame(animId);
        animate();
    }

    function animate() {
        if (!isActive) return;
        ctx.clearRect(0, 0, width, height);
        let alive = false;

        for (const p of pieces) {
            p.x += p.vx;
            p.y += p.vy;
            p.vy += 0.05;
            p.rotation += p.rotSpeed;
            if (p.y > height + 20) p.opacity -= 0.02;
            if (p.opacity > 0) alive = true;

            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rotation * Math.PI / 180);
            ctx.globalAlpha = Math.max(0, p.opacity);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
            ctx.restore();
        }

        if (alive) {
            animId = requestAnimationFrame(animate);
        } else {
            isActive = false;
            ctx.clearRect(0, 0, width, height);
        }
    }

    window.addEventListener('resize', () => {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    });

    // --- Global API ---
    window.MotivConfetti = { launch };
})();
</script>
