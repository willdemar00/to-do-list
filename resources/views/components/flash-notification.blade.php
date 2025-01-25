@if(session('flash_success') || session('flash_error'))
<div>
    @if (session('flash_success'))
        <div class="flash-success flash-message">
            <i class="fa-regular fa-circle-check"></i>
            <p class="m-0">{{ session('flash_success') }}</p>
        </div>
    @endif
    @if (session('flash_error'))
        <div class="flash-error flash-message">
            <i class="fa-regular fa-circle-xmark"></i>
            <p class="m-0">{{ session('flash_error') }}</p>
        </div>
    @endif
</div>
@endif
<script>
    @if (session('flash_success') || session('flash_error'))
        let messagem = document.querySelector('.flash-message');

        if (messagem) {

            messagem.classList.add('slide');

            if (messagem.classList.contains('flash-success')) {
                let successAudio = new Audio('{{ asset('build/assets/audio/success.mp3') }}');
                successAudio.play();
            } else if (messagem.classList.contains('flash-error')) {
                let errorAudio = new Audio('{{ asset('build/assets/audio/error.mp3') }}');
                errorAudio.play();
            }

            setTimeout(() => {
                messagem.classList.remove('slide');
                messagem.classList.add('slide-closed');
            }, 5000);
        }
    @endif
</script>
