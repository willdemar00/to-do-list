<section class="container-img">
    <div class="img-placeholder @error('image') is-invalid @enderror">
        @if (isset($user) && $user->image)
            <img src="{{ $user->path_image }}" alt="img-user">
        @else
            <img src="" alt="" style="display: none">
            <span>
                <i class="fa-solid fa-plus"></i>
                <p class="m-0" label-title="Arraste ou clique aqui para enviar imagens.">Adicionar imagem</p>
            </span>
        @endif
        <input type="file" name="image" accept="image/*" style="display: none">
    </div>
    @error('image')
        <span class="invalid-feedback my-2">{{ $message }}</span>
    @enderror
</section>