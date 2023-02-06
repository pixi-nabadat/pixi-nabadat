<div class="d-flex justify-content-center">

{{--    @can('veiw_slider')--}}
{{--        <a href="{{ route('sliders.show', $slider) }}" class="btn-sm btn-primary me-1">--}}
{{--            <i class="fa fa-eye  my-2"></i>--}}
{{--        </a>--}}
{{--    @endcan--}}

    @can('edit_slider')
        <a href="{{ route('sliders.edit', $slider) }}" class="btn-sm btn-info me-1">
            <i class="fa fa-pencil-square-o  my-2"></i>
        </a>
    @endcan

    @can('delete_slider')
        <button role="button" onclick="destroy('{{ route('sliders.destroy', $slider->id) }}')"
                class="btn btn-danger delete-btn me-1">
            <i class="fa fa-trash-o"></i>
        </button>
    @endcan

</div>