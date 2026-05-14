<x-filament-panels::page>
    @php
        $statuses = \App\Enums\TaskStatus::cases();
        $columns = [
            'todo' => ['label' => 'À Faire', 'color' => 'primary', 'dot' => 'bg-violet-400'],
            'progress' => ['label' => 'En Cours', 'color' => 'warning', 'dot' => 'bg-amber-400'],
            'done' => ['label' => 'Terminé', 'color' => 'success', 'dot' => 'bg-emerald-400'],
        ];
    @endphp

    <div
        x-data="kanbanBoard()"
        class="grid grid-cols-1 lg:grid-cols-3 gap-4"
    >
        @foreach($statuses as $status)
            @php
                $tasks = $this->getTasksByStatus($status);
                $col = $columns[$status->value] ?? $columns['todo'];
            @endphp

            <div
                class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-4 min-h-[400px] flex flex-col"
            >
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/10">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $col['dot'] }}"></span>
                        <h3 class="text-sm font-bold text-white">{{ $col['label'] }}</h3>
                    </div>
                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-white/10 text-white/70">
                        {{ $tasks->count() }}
                    </span>
                </div>

                <div
                    class="flex-1 space-y-3"
                    data-status="{{ $status->value }}"
                    x-ref="col-{{ $status->value }}"
                >
                    @foreach($tasks as $task)
                        <div
                            class="rounded-xl border border-white/10 bg-white/5 p-4 cursor-grab active:cursor-grabbing transition-all hover:bg-white/10 hover:-translate-y-0.5 hover:shadow-lg group relative overflow-hidden"
                            data-task-id="{{ $task->id }}"
                        >
                            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-xl
                                @if($task->priority->value === 'high') bg-danger-500
                                @elseif($task->priority->value === 'medium') bg-warning-500
                                @else bg-success-500
                                @endif
                            "></div>

                            <div class="pl-3">
                                <h4 class="text-sm font-semibold text-white mb-1">{{ $task->title }}</h4>
                                @if($task->description)
                                    <p class="text-xs text-white/50 mb-2 line-clamp-2">{{ $task->description }}</p>
                                @endif

                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                                        @if($task->category->value === 'design') bg-violet-500/20 text-violet-300
                                        @elseif($task->category->value === 'dev') bg-cyan-500/20 text-cyan-300
                                        @elseif($task->category->value === 'marketing') bg-pink-500/20 text-pink-300
                                        @else bg-amber-500/20 text-amber-300
                                        @endif
                                    ">
                                        {{ $task->category->getLabel() }}
                                    </span>
                                    <span class="text-[10px] text-white/40 flex items-center gap-1">
                                        <x-heroicon-o-clock class="w-3 h-3" />
                                        {{ $task->estimated_time }}min
                                    </span>
                                </div>

                                @if($status->value !== 'done')
                                    <div class="mt-2 pl-0">
                                        <button
                                            type="button"
                                            @click="$wire.moveTask({{ $task->id }}, 'done')"
                                            class="text-[11px] px-2 py-1 rounded-md bg-success-500/20 border border-success-500/30 text-success-400 hover:bg-success-500/30 transition-colors font-semibold"
                                        >
                                            <x-heroicon-o-check class="w-3 h-3 inline" />
                                            Terminer
                                        </button>
                                    </div>
                                @else
                                    <div class="mt-2 text-[11px] text-success-400 flex items-center gap-1">
                                        <x-heroicon-o-check-circle class="w-3 h-3" />
                                        Complété 🎉
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Sortable.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        function kanbanBoard() {
            return {
                init() {
                    const columns = ['todo', 'progress', 'done'];

                    columns.forEach(status => {
                        const el = this.$refs['col-' + status];
                        if (!el) return;

                        new Sortable(el, {
                            group: 'kanban',
                            animation: 150,
                            ghostClass: 'opacity-50',
                            dragClass: 'cursor-grabbing',
                            delay: 0,
                            onEnd: (evt) => {
                                const taskId = evt.item.dataset.taskId;
                                const newStatus = evt.to.dataset.status;

                                if (evt.from.dataset.status === newStatus) return;

                                this.$wire.moveTask(taskId, newStatus);
                            }
                        });
                    });
                }
            }
        }
    </script>

    {{-- Confetti --}}
    <canvas id="confetti-canvas" class="fixed inset-0 pointer-events-none z-50" style="display:none;"></canvas>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('confetti', () => {
                launchConfetti();
            });
        });

        function launchConfetti() {
            const canvas = document.getElementById('confetti-canvas');
            canvas.style.display = 'block';
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const colors = ['#6c5ce7','#a29bfe','#fd79a8','#00cec9','#fdcb6e','#00b894','#e74c3c','#f39c12'];
            const pieces = [];
            for (let i = 0; i < 150; i++) {
                pieces.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height - canvas.height,
                    w: Math.random() * 10 + 5,
                    h: Math.random() * 6 + 3,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    vx: (Math.random() - 0.5) * 4,
                    vy: Math.random() * 3 + 2,
                    rotation: Math.random() * 360,
                    rotSpeed: (Math.random() - 0.5) * 10,
                    opacity: 1
                });
            }

            let alive = true;
            function animate() {
                if (!alive) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                alive = false;
                pieces.forEach(p => {
                    p.x += p.vx;
                    p.y += p.vy;
                    p.vy += 0.05;
                    p.rotation += p.rotSpeed;
                    if (p.y > canvas.height + 20) p.opacity -= 0.02;
                    if (p.opacity > 0) alive = true;
                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.rotation * Math.PI / 180);
                    ctx.globalAlpha = Math.max(0, p.opacity);
                    ctx.fillStyle = p.color;
                    ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
                    ctx.restore();
                });
                if (alive) requestAnimationFrame(animate);
                else canvas.style.display = 'none';
            }
            animate();
        }
    </script>
</x-filament-panels::page>
