
@if (session('success'))
    <div
        data-success-modal
        x-data="{ show: true }"
        x-show="show"
        x-cloak
        x-transition.opacity.duration.300ms
        x-init="setTimeout(() => show = false, 3500)"
        style="
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(15, 23, 42, 0.50);
            backdrop-filter: blur(5px);
        "
    >
        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            style="
                width: 100%;
                max-width: 340px;
                min-height: 0;
                padding: 30px 24px;
                border-radius: 24px;
                background: #ffffff;
                text-align: center;
                box-shadow: 0 25px 60px rgba(0,0,0,0.18);
                flex-shrink: 0;
            "
        >
            {{-- Animated Check --}}
            <div style="
                width: 76px;
                height: 76px;
                margin: 0 auto 18px;
            ">
                <svg
                    viewBox="0 0 80 80"
                    xmlns="http://www.w3.org/2000/svg"
                    style="
                        display: block;
                        width: 76px !important;
                        height: 76px !important;
                        max-width: 76px !important;
                        min-width: 76px !important;
                        overflow: visible;
                    "
                >
                    <circle
                        cx="40"
                        cy="40"
                        r="34"
                        fill="none"
                        stroke="#10B981"
                        stroke-width="4"
                        stroke-linecap="round"
                        class="success-circle"
                    />

                    <path
                        d="M23 41L34 52L58 28"
                        fill="none"
                        stroke="#10B981"
                        stroke-width="5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="success-tick"
                    />
                </svg>
            </div>

            <h3 style="
                margin: 0;
                color: #0f172a;
                font-size: 21px;
                font-weight: 800;
            ">
                Berhasil!
            </h3>

            <p style="
                margin: 9px 0 0;
                color: #64748b;
                font-size: 13px;
                line-height: 1.6;
            ">
                {{ session('success') }}
            </p>

            <button
                type="button"
                onclick="this.closest('[data-success-modal]').style.display='none'"
                style="
                    width: 100%;
                    margin-top: 24px;
                    padding: 12px;
                    border: none;
                    border-radius: 12px;
                    background: #4F7DF3;
                    color: white;
                    font-size: 13px;
                    font-weight: 700;
                    cursor: pointer;
                "
            >
                Lanjutkan
            </button>
        </div>
    </div>

    <style>
        .success-circle {
            stroke-dasharray: 214;
            stroke-dashoffset: 214;
            animation: drawCircle 0.7s ease-out forwards;
        }

        .success-tick {
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
            animation: drawTick 0.45s 0.65s ease-out forwards;
        }

        @keyframes drawCircle {
            to { stroke-dashoffset: 0; }
        }

        @keyframes drawTick {
            to { stroke-dashoffset: 0; }
        }
    </style>
@endif
