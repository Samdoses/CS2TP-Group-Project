@props(['lightOpacity', 'darkOpacity'])
<!-- old video background, copy pasted, not in use right now -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden transition-colors duration-700 ease-in-out">
    <style>
        @keyframes diagonalMouseDrift {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 480px 480px;
            }
        }
    </style>

    <div class="absolute inset-0 bg-slate-100 transition-colors duration-700 ease-in-out dark:bg-slate-950"></div>

    <div
        class="absolute inset-0 opacity-40 transition-opacity duration-700 ease-in-out dark:opacity-0"
        style="
            background-image: url('{{ asset('images/mouseBackground.png') }}');
            background-repeat: repeat;
            background-size: 320px 320px;
            animation: diagonalMouseDrift 40s linear infinite;
            will-change: background-position, opacity;
        "
    ></div>

    <div
        class="absolute inset-0 opacity-0 transition-opacity duration-700 ease-in-out dark:opacity-[0.34]"
        style="
            background-image: url('{{ asset('images/mouseBackgroundBlack.png') }}');
            background-repeat: repeat;
            background-size: 320px 320px;
            animation: diagonalMouseDrift 40s linear infinite;
            will-change: background-position, opacity;
        "
    ></div>

    <div class="absolute inset-0 bg-white/28 transition-colors duration-700 ease-in-out dark:bg-slate-950/24"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/12 to-white/18 transition-colors duration-700 ease-in-out dark:via-slate-950/12 dark:to-slate-950/22"></div>
</div>



