<x-filament-panels::page>
    @php
        $statuses = \App\Enums\TaskStatus::cases();
        $columns = [
            'todo'     => ['label' => 'À Faire',  'dot' => '#a29bfe', 'dotClass' => 'dot-violet'],
            'progress' => ['label' => 'En Cours', 'dot' => '#fdcb6e', 'dotClass' => 'dot-amber'],
            'done'     => ['label' => 'Terminé',  'dot' => '#00b894', 'dotClass' => 'dot-green'],
        ];
    @endphp

    <style>
        /* ===== PAGE HEADER ===== */
        .kb-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .kb-title {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #a29bfe, #00cec9);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .kb-btn-new {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 50px;
            background: linear-gradient(135deg, #6c5ce7, #fd79a8);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(108, 92, 231, 0.4);
            transition: all 0.3s ease;
        }

        .kb-btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(108, 92, 231, 0.6);
        }

        /* ===== BOARD GRID — always 3 columns ===== */
        .kb-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            align-items: start;
        }

        /* ===== COLUMN ===== */
        .kb-column {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 16px;
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .kb-col-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .kb-col-title {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kb-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .kb-col-label {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
        }

        .kb-col-count {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        /* ===== ITEMS CONTAINER ===== */
        .kb-items {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-height: 60px;
        }

        /* ===== TASK CARD ===== */
        .kb-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 14px 14px 14px 17px;
            cursor: grab;
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .kb-card:active { cursor: grabbing; }

        .kb-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
            border-color: rgba(255, 255, 255, 0.18);
        }

        /* Priority bar — left 3px */
        .kb-priority-bar {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            border-radius: 10px 0 0 10px;
        }

        .kb-priority-high   { background: #e74c3c; }
        .kb-priority-medium { background: #f39c12; }
        .kb-priority-low    { background: #00b894; }

        .kb-card-title {
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .kb-card-desc {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 10px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .kb-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
        }

        /* Category tag */
        .kb-tag {
            font-size: 10px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        .kb-tag-design    { background: rgba(108, 92, 231, 0.2); color: #a29bfe; }
        .kb-tag-dev       { background: rgba(0, 206, 201, 0.2);  color: #00cec9; }
        .kb-tag-marketing { background: rgba(253, 121, 168, 0.2); color: #fd79a8; }
        .kb-tag-personal  { background: rgba(253, 203, 110, 0.2); color: #fdcb6e; }
        .kb-tag-default   { background: rgba(162, 155, 254, 0.15); color: #a29bfe; }

        /* Time */
        .kb-time {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Actions row */
        .kb-card-actions {
            margin-top: 10px;
        }

        .kb-btn-done {
            font-size: 11px;
            padding: 5px 12px;
            border-radius: 7px;
            background: rgba(0, 184, 148, 0.15);
            border: 1px solid rgba(0, 184, 148, 0.3);
            color: #00b894;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .kb-btn-done:hover {
            background: rgba(0, 184, 148, 0.28);
            color: #ffffff;
        }

        .kb-completed {
            font-size: 11px;
            color: #00b894;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
            margin-top: 10px;
        }

        /* Empty state */
        .kb-empty {
            text-align: center;
            padding: 32px 16px;
            color: rgba(255, 255, 255, 0.2);
            font-size: 12px;
            border: 1px dashed rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            flex: 1;
        }

        /* Ghost drag */
        .kb-ghost {
            opacity: 0.4;
            border: 1px dashed rgba(108, 92, 231, 0.5) !important;
        }

        /* Responsive — tablet only */
        @media (max-width: 900px) {
            .kb-board { grid-template-columns: 1fr; }
        }
    </style>

    <div x-data="kanbanBoard()">

        {{-- ===== BOARD ===== --}}
        <div class="kb-board">
            @foreach($statuses as $status)
                @php
                    $tasks = $this->getTasksByStatus($status);
                    $col   = $columns[$status->value] ?? $columns['todo'];
                @endphp

                <div class="kb-column">

                    {{-- Column header --}}
                    <div class="kb-col-header">
                        <div class="kb-col-title">
                            <span class="kb-dot" style="background: {{ $col['dot'] }};
                                box-shadow: 0 0 6px {{ $col['dot'] }}88;"></span>
                            <span class="kb-col-label">{{ $col['label'] }}</span>
                        </div>
                        <span class="kb-col-count">{{ $tasks->count() }}</span>
                    </div>

                    {{-- Task cards --}}
                    <div class="kb-items"
                         data-status="{{ $status->value }}"
                         x-ref="col-{{ $status->value }}">

                        @forelse($tasks as $task)
                            <div class="kb-card" data-task-id="{{ $task->id }}">

                                {{-- Priority bar --}}
                                <div class="kb-priority-bar
                                    @if(in_array($task->priority->value, ['high', 'urgent'])) kb-priority-high
                                    @elseif($task->priority->value === 'medium') kb-priority-medium
                                    @else kb-priority-low
                                    @endif
                                "></div>

                                {{-- Title --}}
                                <div class="kb-card-title">{{ $task->title }}</div>

                                {{-- Description --}}
                                @if($task->description)
                                    <div class="kb-card-desc">{{ $task->description }}</div>
                                @endif

                                {{-- Footer: tag + time --}}
                                <div class="kb-card-footer">
                                    <span class="kb-tag
                                        @if($task->category->value === 'design') kb-tag-design
                                        @elseif($task->category->value === 'dev') kb-tag-dev
                                        @elseif($task->category->value === 'marketing') kb-tag-marketing
                                        @elseif($task->category->value === 'personal') kb-tag-personal
                                        @else kb-tag-default
                                        @endif
                                    ">{{ $task->category->getLabel() }}</span>

                                    <span class="kb-time">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        {{ $task->estimated_time }}min
                                    </span>
                                </div>

                                {{-- Action --}}
                                <div class="kb-card-actions">
                                    @if($status->value !== 'done')
                                        <button type="button" class="kb-btn-done"
                                                @click="$wire.moveTask({{ $task->id }}, 'done')">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2.5">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Terminer
                                        </button>
                                    @else
                                        <div class="kb-completed">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2.5">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                <polyline points="22 4 12 14.01 9 11.01"/>
                                            </svg>
                                            Complété 🎉
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="kb-empty">Aucune tâche</div>
                        @endforelse

                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Sortable.js --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        function kanbanBoard() {
            return {
                init() {
                    ['todo', 'progress', 'done'].forEach(status => {
                        const el = this.$refs['col-' + status];
                        if (!el) return;

                        new Sortable(el, {
                            group: 'kanban',
                            animation: 150,
                            ghostClass: 'kb-ghost',
                            delay: 0,
                            onEnd: (evt) => {
                                const taskId   = evt.item.dataset.taskId;
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
    <canvas id="confetti-canvas" style="position:fixed;inset:0;pointer-events:none;z-index:9998;display:none;"></canvas>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('confetti', () => launchConfetti());
        });

        function launchConfetti() {
            const canvas = document.getElementById('confetti-canvas');
            canvas.style.display = 'block';
            canvas.width  = window.innerWidth;
            canvas.height = window.innerHeight;
            const ctx = canvas.getContext('2d');
            const colors = ['#6c5ce7','#a29bfe','#fd79a8','#00cec9','#fdcb6e','#00b894','#e74c3c','#f39c12'];
            const pieces = Array.from({ length: 160 }, () => ({
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
            }));

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                let alive = false;
                pieces.forEach(p => {
                    p.x += p.vx; p.y += p.vy; p.vy += 0.05;
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
