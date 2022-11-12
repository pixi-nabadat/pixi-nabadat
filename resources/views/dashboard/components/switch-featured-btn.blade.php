<div class="d-flex justify-content-center">
    <div class="media mb-2">
        <div class="media-body  icon-state">
            <label class="switch">
                <input type="checkbox" onchange="changeModelStatus('{{$url}}','{{$model->id}}')" name="featured" {{$model->featured==1?'checked':''}}>
                <span class="switch-state"></span>
            </label>
        </div>
    </div>
</div>
