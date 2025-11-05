{{-- Recursive Partial for Multi-Level Children --}}
@foreach($children as $index => $child)
    <div class="child-row level-{{ $level }} {{ $level > 1 ? 'sub-child' : '' }}">
        <div class="child-content">
            <div class="form-check">
                <input type="checkbox"
                       class="form-check-input child-checkbox level-{{ $level }}"
                       id="child{{ $child->id }}"
                       name="jenis_temuan_ids[]"
                       value="{{ $child->id }}"
                       data-parent-id="{{ $rootParentId }}"
                       data-direct-parent="{{ $child->id_parent }}"
                       data-level="{{ $level }}">
            </div>

            <div class="child-info">
                <div class="d-flex align-items-center">
                    @for($i = 1; $i < $level; $i++)
                        <i class="fas fa-arrow-right text-muted mr-1"></i>
                    @endfor
                    <i class="fas fa-{{ $level == 1 ? 'arrow-right' : 'long-arrow-alt-right' }} text-muted mr-2"></i>

                    <span class="child-name">
                        @if($child->rekomendasi)
                            {{ ucfirst($child->rekomendasi) }}
                        @else
                            {{ $child->nama_temuan }}
                        @endif
                    </span>

                    @if($child->kode_temuan)
                        <span class="badge badge-secondary ml-2">{{ $child->kode_temuan }}</span>
                    @endif

                    <small class="text-muted ml-2">(ID: {{ $child->id }})</small>

                    @if(count($child->children) > 0)
                        <span class="badge badge-info ml-2">
                            <i class="fas fa-layer-group"></i> {{ count($child->children) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recursive call for grandchildren --}}
        @if(count($child->children) > 0)
            <div class="grandchildren-container level-{{ $level + 1 }}">
                @include('AdminTL.user-control.partials.hierarchy-children', [
                    'children' => $child->children,
                    'rootParentId' => $rootParentId,
                    'level' => $level + 1
                ])
            </div>
        @endif
    </div>
@endforeach
