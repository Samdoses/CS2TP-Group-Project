@props(['lightOpacity' => 'opacity-20', 'darkOpacity' => 'opacity-40'])

<div class="z-[-1] overflow-hidden" style="pointer-events: none;">
    <!-- background of the mice -->
    <div class="absolute inset-0 bg-slate-100 transition-colors duration-700 ease-in-out dark:bg-slate-950"></div>
    <div class="absolute inset-0 bg-white/30 transition-colors duration-700 ease-in-out dark:bg-slate-950/30"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/10 to-white/20 transition-colors duration-700 ease-in-out dark:via-slate-950/10 dark:to-slate-950/20"></div>

    <!-- mouse picture area with css-->
    <canvas id="mice-canvas" style="position:absolute;inset:0;width:100%;height:100%;pointer-events:auto;"></canvas>
</div>

<script>
//to add mouse interaction with the mice as they fall, we use javascript
(function () {
    const canvas = document.getElementById('mice-canvas');
    const ctx    = canvas.getContext('2d');

    // declare the variables
    //amount of mice
    const COUNT = 14;
    const SIZE_MIN = 52;
    const SIZE_MAX = 70;
    //movement variables
    const FALL_MIN = 0.2;
    const FALL_MAX = 1.05;
    const DRIFT_MAX = 0.18;
    const SPINNY_MIN  = 0.12;
    const SPINNY_MAX  = 0.24;
    //area where cursor take effect on mice
    const REPEL_RADIUS = 100;
    //how strong they get knocked back and how quick it loses speed
    const REPEL_FORCE  = 4.5;
    const FRICTION  = 0.88;

    //later i will put a dark mode version of the mouse maybe
    const LIGHT_SRC = '{{ asset('mouse.png') }}';
    const DARK_SRC  = '{{ asset('mouse.png') }}';

    //array holding all the data for the mice and storing location of cursor intitally
    let W, H, lightImg, darkImg, mice = [];
    let cursorX = -9999, cursorY = -9999;
    let isInitialLoad = true;

    function rand(a, b) { return Math.random() * (b - a) + a; }

    function resize() {
        W = canvas.width  = canvas.offsetWidth;
        H = canvas.height = canvas.offsetHeight;
    }

    function makeMouse(spread) {
        const size = rand(SIZE_MIN, SIZE_MAX);
        return {
            //we want it to appear at random locations with their size taken into account
            x:        rand(size, W - size),
            //if they are loading for the first time then space them out randomly, otherwise hide them far from the screen so they fall randomly
            y: isInitialLoad ? rand(0, H) : -size - rand(100, 800),
            size,
            //sets default variables
            baseVY:   rand(FALL_MIN, FALL_MAX),
            baseVX:   rand(-DRIFT_MAX, DRIFT_MAX),
            vx: 0,
            vy: 0,
            rot:      rand(-0.15, 0.15),
            rotSpeed: rand(-0.003, 0.003),
            alpha:    rand(SPINNY_MIN, SPINNY_MAX),
            //intital size is 1 before it gets hit
            scaleX: 1,
            scaleY: 1,
        };
    }

    function init() {
        //init for intialising
        resize();
        mice = Array.from({ length: COUNT }, () => makeMouse(true));
        //assigns every mouse its speed
        mice.forEach(m => { m.vx = m.baseVX; m.vy = m.baseVY; });
        isInitialLoad = false;
    }

    function isDark() {
        return document.documentElement.classList.contains('dark');
    }

    function loop() {
        //so this will repeat assigning stats to the mice
        ctx.clearRect(0, 0, W, H);
        const img = isDark() ? darkImg : lightImg;

        mice.forEach(m => {

            //take into aspect the images size
            const aspect = img.naturalWidth / img.naturalHeight;
            const halfW = (m.size * aspect) / 2;
            const halfH = m.size / 2;

            //rrepulsing mice
            const dx = m.x - cursorX;
            const dy = m.y - cursorY;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < REPEL_RADIUS && dist > 0) {
                //takes into account the strength at whichthe mice are hit they should go further away
                const strength = (1 - dist / REPEL_RADIUS) * REPEL_FORCE;
                m.vx += (dx / dist) * strength;
                m.vy += (dy / dist) * strength;

                //makes the mice seem squishy when u hit them, more satisfying
                const squish = 1 - (1 - dist / REPEL_RADIUS) * 0.2;
                m.scaleX = 1 + (1 - squish) * 0.15;
                m.scaleY = squish;
            } else {
                //after it done squishing it should go to normal size
                m.scaleX += (1 - m.scaleX) * 0.08;
                m.scaleY += (1 - m.scaleY) * 0.08;
            }

            //friction calculations with the velocity so it seems more realistic
            //makes sure the extra velocity after being knocked back decrease with friction calulcation
            m.vx = m.vx * FRICTION + m.baseVX * (1 - FRICTION);
            m.vy = m.vy * FRICTION + m.baseVY * (1 - FRICTION);

            //moving
            m.x   += m.vx;
            m.y   += m.vy;
            m.rot += m.rotSpeed;

            //creating mice
            if (img && img.naturalWidth > 0) {
                ctx.save();
                ctx.globalAlpha = m.alpha;
                ctx.translate(m.x, m.y);
                ctx.rotate(m.rot);
                ctx.scale(m.scaleX, m.scaleY);
                //since the image is not a perfect square and rectangle sometimes it stretches out and makes it enormous
                //tracking aspect and using it in calculation when making image should stop the bug
                ctx.drawImage(img,0, 0, img.naturalWidth, img.naturalHeight,-halfW, -halfH, m.size * aspect, m.size);
                ctx.restore();
            }

            //recycling mice
            if (m.y > H + m.size * 2) {
                const fresh = makeMouse(false);
                Object.assign(m, fresh);
                //we ensure they dont all appear at once by sending them in different
                m.y = -m.size - rand(0, 500);
                m.vx = m.baseVX;
                m.vy = m.baseVY;
            }

            //constraints
            if (m.x >  W + m.size) m.x = -m.size;
            if (m.x < -m.size)     m.x =  W + m.size;
        });

        requestAnimationFrame(loop);
    }

    //makes sure the cursor is being tracked
    window.addEventListener('mousemove', e => {
        const r = canvas.getBoundingClientRect();
        cursorX = e.clientX - r.left;
        cursorY = e.clientY - r.top;
    });

    //makes sure it works for touchscreen as well (we have phone access)
    window.addEventListener('touchmove', e => {
        const r = canvas.getBoundingClientRect();
        cursorX = e.touches[0].clientX - r.left;
        cursorY = e.touches[0].clientY - r.top;
    }, { passive: true });

    window.addEventListener('touchend', () => {
        cursorX = -9999;
        cursorY = -9999;
    });

    //when the mouse leaves the window cursor reset
    window.addEventListener('mouseleave', () => {
        cursorX = -9999;
        cursorY = -9999;
    });

    //these make sure the mice arent created until the images have been loaded
    //promise ensures that the pending part happens so it does wait
    function loadImg(src) {
        return new Promise(resolve => {
            const img = new Image();
            img.onload  = () => resolve(img);
            img.onerror = () => resolve(img);
            img.src = src;
        });
    }

    Promise.all([loadImg(LIGHT_SRC), loadImg(DARK_SRC)]).then(([l, d]) => {
        lightImg = l;
        darkImg  = d;
        init();
        loop();
    });

    window.addEventListener('resize', resize);
})();
</script>
