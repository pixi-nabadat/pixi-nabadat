<div class="d-flex justify-content-center">
    <div class="media mb-2">
        <div class="media-body  icon-state">
            <label class="switch">
                <input type="checkbox" onchange="changeModelStatus('{{$url}}','{{$model->id}}')" name="is_support_auto_service" {{$model->is_support_auto_service==1?'checked':''}}>
                <span class="switch-state"></span>
            </label>
        </div>
    </div>
</div>
