@if ($paginator->hasPages())
    <nav aria-label="Navegação de página">
        <ul class="pagination">
            {{-- Link da Página Anterior --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Anterior</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
                </li>
            @endif

            {{-- Elementos de Paginação --}}
            @foreach ($elements as $element)
                {{-- Separador de "Três Pontos" --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array de Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @elseif ($page == 1 || $page == 2 || $page == $paginator->lastPage() || $page == $paginator->lastPage() - 1 || ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2))
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == 3 || $page == $paginator->lastPage() - 2)
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Link da Próxima Página --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Próxima</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Próxima</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

{{-- Exibindo Informações da Página --}}
<div class="pagination-info">
    Exibindo Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}. Total de Registros:
    {{ $paginator->total() }}
</div>

<style>
    @media (max-width: 950px) {
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination-info {
            text-align: center;
            font-size: 0.9em;
        }
    }
</style>
