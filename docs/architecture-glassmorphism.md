# Architecture Glassmorphism — MotivFlow Filament v3

## Vue d'ensemble

Intégration du design spatial glassmorphism du fichier `public/index.html` dans l'interface admin Filament v3 existante. Le but est de garder 100% des fonctionnalités CRUD/resources/pages/widgets tout en appliquant une couche visuelle premium (Three.js background + glassmorphism + animations).

---

## 🏗️ Architecture technique

### Couche 1 — Background immersif (Three.js)

**Fichier** : `resources/views/filament/admin/hooks/threejs-background.blade.php`

Injecté via le render hook `panels::body.start` dans `AdminPanelProvider`.

**Specs** :
- Canvas `position:fixed; inset:0; z-index:0; pointer-events:none`
- **Mode Normal** (par défaut) : 1500 particules vertex-colored + 25 wireframes géométriques (icosaèdres, octaèdres, tétraèdres, cubes) + 1 torus knot + parallax souris
- **Mode Léger** (auto-détecté) : 500 particules + 10 wireframes, pas de torus knot, parallax désactivé
- **Détection mode léger** : `navigator.hardwareConcurrency < 4` OU `window.innerWidth < 768` OU `prefers-reduced-motion`
- CDN : `https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js`
- Gestion resize via `window.addEventListener('resize', ...)`

### Couche 2 — Thème CSS (Glassmorphism)

**Fichier** : `public/css/motivflow.css`

Styles globaux qui surchargent les classes CSS de Filament v3. L'asset est enregistré dans `AdminPanelProvider` via `->assets([Css::make('motivflow', '/css/motivflow.css')])`.

**Composants stylés** :
| Composant Filament | Sélecteur CSS | Style appliqué |
|---|---|---|
| Body | `.fi-body` | Background `#0a0a1a` |
| Sidebar | `.fi-sidebar` | `rgba(10,10,26,0.95)` + `backdrop-filter:blur(20px)` |
| Topbar | `.fi-topbar` | `rgba(10,10,26,0.8)` + `backdrop-filter:blur(20px)` |
| Main content | `.fi-main` | Background `#0a0a1a` |
| Cards/Tables | `.fi-wi-widget > div`, `.fi-ta-table tbody tr` | Glass surface + hover |
| Form sections | `.fi-fo-section > div` | Glass + border radius 16px |
| Inputs | `.fi-input`, `.fi-fo-text-input > div` | Dark glass + focus ring violet |
| Buttons primary | `.fi-btn-color-primary` | Gradient violet + hover glow |
| Modals | `.fi-modal-content` | `rgba(20,20,40,0.95)` + blur |
| Toasts | Filament notification | Slide depuis droite |
| Scrollbar | `::-webkit-scrollbar-*` | Fine, sombre, 6px |

### Couche 3 — Widgets reskin

**QuoteWidget** (`resources/views/filament/admin/widgets/quote-widget.blade.php`)
- Banner gradient `135deg, rgba(108,92,231,0.2), rgba(253,121,168,0.15)`
- Bordure `rgba(108,92,231,0.2)`
- Animation `slideIn 0.6s ease`
- Glow radial en `::before` (top-right)
- Icône 💡 32px opacity 30%

**ThreeHeroWidget** (`resources/views/filament/admin/widgets/three-hero-widget.blade.php`)
- 4 stat cards en grid (tâches terminées, temps focus, streak, score)
- Chaque card : glass + icône circulaire colorée + badge % + barre gradient bottom
- Hover : `translateY(-4px)` + shadow

### Couche 4 — Effets bonus

**Confetti** (`resources/views/filament/admin/hooks/confetti-overlay.blade.php`)
- Canvas overlay `position:fixed; z-index:9999; pointer-events:none`
- API globale : `window.MotivConfetti.launch()`
- 200 particules, gravité, rotation, fade out
- Prêt à être branché sur n'importe quel événement Livewire/Alpine

---

## 🎨 Spécifications visuelles détaillées

### Palette de couleurs
```css
--primary:       #6c5ce7;   /* violet */
--primary-light: #a29bfe;   /* violet clair */
--primary-dark:  #4a3db5;   /* violet foncé */
--secondary:     #00cec9;   /* cyan */
--accent:        #fd79a8;   /* rose */
--accent2:       #fdcb6e;   /* jaune/orange */
--success:       #00b894;   /* vert */
--warning:       #f39c12;   /* orange */
--danger:        #e74c3c;   /* rouge */
--bg-dark:       #0a0a1a;   /* fond sombre */
--bg-card:       rgba(255,255,255,0.06);
--bg-card-hover: rgba(255,255,255,0.1);
--text-primary:  #ffffff;
--text-secondary:rgba(255,255,255,0.7);
--text-muted:    rgba(255,255,255,0.4);
--border:        rgba(255,255,255,0.1);
--glass:         rgba(255,255,255,0.08);
--shadow:        0 8px 32px rgba(0,0,0,0.3);
--radius:        16px;
--radius-sm:     10px;
```

### Animations CSS
```css
@keyframes fadeUp   { from { opacity:0; transform:translateY(15px); } to { opacity:1; transform:translateY(0); } }
@keyframes slideIn  { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
@keyframes pulseGlow { 0%,100% { box-shadow:0 0 0 0 rgba(253,203,110,0.2); } 50% { box-shadow:0 0 20px 5px rgba(253,203,110,0.15); } }
@keyframes toastIn  { from { opacity:0; transform:translateX(100px); } to { opacity:1; transform:translateX(0); } }
@keyframes toastOut { to { opacity:0; transform:translateX(100px); } }
@keyframes modalSlide { from { opacity:0; transform:translateY(30px) scale(0.95); } to { opacity:1; transform:translateY(0) scale(1); } }
```

### Composants `index.html` → Mapping Filament

| Composant `index.html` | Équivalent Filament | Implémenté dans |
|---|---|---|
| Sidebar (nav 260px) | `.fi-sidebar` | `motivflow.css` |
| Topbar (search, avatar, notif) | `.fi-topbar` | `motivflow.css` |
| Quote banner | `QuoteWidget` | `quote-widget.blade.php` |
| Stats row (4 cards) | `ThreeHeroWidget` | `three-hero-widget.blade.php` |
| Task cards | Resource Task List | `motivflow.css` (table rows) |
| Kanban columns | Page KanbanBoardPage | `motivflow.css` (à enrichir) |
| Calendar | Page Calendar | `motivflow.css` (à enrichir) |
| Modal tâche | Filament modal | `motivflow.css` |
| Audio player | Hub Média | Pas encore reskin |
| Toast | Filament notification | `motivflow.css` |
| Confetti | Bonus | `confetti-overlay.blade.php` |

---

## 🔌 Points d'extension futurs

### Brancher le confetti
```javascript
// Dans un événement Livewire/Alpine
window.MotivConfetti.launch();
```

### Ajouter des animations d'entrée aux widgets
```html
<div class="animate-fade-up" style="animation-delay: 0.1s">
```

### Thème dynamique (mode jour/nuit)
Le CSS est déjà 100% dark-mode. Pour un mode clair, il faudrait une classe `light-mode` sur `body` et inverser les `rgba`.

---

## 📦 Dépendances

| Dépendance | Source | Usage |
|---|---|---|
| Three.js r128 | CDN unpkg | Background spatial |
| Font Inter | Google Fonts | Typography (optionnel) |
| Font Awesome 6 | CDN (déjà dans index.html) | Icons (optionnel) |

---

## ⚠️ Points d'attention

1. **Performance Three.js** : Le mode léger est crucial. Sur appareils mobiles, 1500 particules peuvent faire chuter les FPS.
2. **Livewire** : Le canvas Three.js est en `pointer-events:none` et n'est pas remplacé par les mises à jour Livewire. Il faut s'assurer que le script ne se réinitialise pas à chaque requête Livewire.
3. **Z-index** : Le canvas Three.js est à `z-index:0`, le contenu Filament à `z-index:1+`. Les modals/toasts doivent être au-dessus (`z-index:1000+`).
4. **Scroll** : Le canvas est `position:fixed`, donc il ne scrolle pas. C'est le comportement souhaité.

