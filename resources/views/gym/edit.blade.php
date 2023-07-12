@extends('layout.app')
@section('content')
<form action="{{ route('gym.update') }}" class="container card mt-5" method="post" enctype="multipart/form-data">
    @csrf
    <div class="d-flex align-items-center p-5 justify-content-between">
        <div class="card-image">
            <div class="top">
                <p>Kéo và thả tải lên hình ảnh</p>
            </div>
            <div class="drag-area">
                <span class="visible">
                    <div class="container-image"></div>
                    Kéo và thả hình ảnh tại đây hoặc
                    <span class="select" role="button">Tải lên</span>
                </span>
                <span class="on-drop">Thả hình ảnh tại đây</span>
                <input name="file[]" type="file" class="file" multiple />
            </div>
        </div>
        <div class="register-form">
            <!-- Bên chứa trường input -->
            <h1 style="color: #5256ad;">Chỉnh sửa thông tin phòng gym</h1>
            <div class="form-group">
                <label for="name">Tên chủ phòng gym:</label>
                <input type="text" id="name" name="name" class="form-control" autocomplete="off" value="{{ $gym->nameOwner }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" autocomplete="off" value="{{ $gym->email }}" required>
            </div>
            <div class="form-group">
                <label for="nameGym">Tên phòng gym:</label>
                <input type="text" id="nameGym" name="nameGym" class="form-control" autocomplete="off" value="{{ $gym->name }}" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" class="form-control" autocomplete="off" value="{{ $gym->address }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" class="form-control" autocomplete="off" value="{{ $gym->phone }}" required>
            </div>
            <div class="form-group">
                <label for="price">Mức giá 1 tháng:</label>
                <input type="text" id="price" name="price" class="form-control" autocomplete="off" value="{{ $gym->price }}" required>
            </div>
            <div class="form-group">
                <label for="services">Dịch vụ đi kèm:</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="checkbox-item">
                            @if($gym->pool == 1)
                            <input type="checkbox" id="pool" name="services[]" value="pool" checked>
                            @else
                            <input type="checkbox" id="pool" name="services[]" value="pool">
                            @endif
                            <label for="pool">Hồ bơi</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox-item">
                            @if($gym->sauna == 1)
                            <input type="checkbox" id="sauna" name="services[]" value="sauna" checked>
                            @else
                            <input type="checkbox" id="sauna" name="services[]" value="sauna">
                            @endif
                            <label for="sauna">Xông hơi</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox-item">
                            @if($gym->parking == 1)
                            <input type="checkbox" id="park" name="services[]" value="parking" checked>
                            @else
                            <input type="checkbox" id="park" name="services[]" value="parking">
                            @endif
                            <label for="parking">Bãi đỗ xe</label>
                        </div>
                    </div>
                    <!-- Thêm các tùy chọn dịch vụ khác vào đây -->
                </div>
            </div>

            <br>
            <button type="submit" class="btn btn-primary form-control" style="background-color: #5256ad;">Chỉnh sửa</button>
        </div>
    </div>
</form>


<style>
    .form-control {
        background-color: #fafbff;
        border-color: #878a9a;
        transition: border-color 0.3s;
    }

    .form-control:hover {
        border-color: #5256ad;
    }

    .form-control:focus {
        border-color: #5256ad;
        box-shadow: none;
    }

    .card {
        padding: 15px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        overflow: hidden;
        background: #fafbff;
    }

    .card-image {
        width: 400px;
        height: auto;
        padding: 15px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        overflow: hidden;
        background: #fafbff;
    }

    .card-image .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .card-image p {
        font-size: 0.9rem;
        font-weight: 600;
        color: #878a9a;
    }

    .card-image button {
        outline: 0;
        border: 0;
        -webkit-appearence: none;
        background: #5256ad;
        color: #fff;
        border-radius: 4px;
        transition: 0.3s;
        cursor: pointer;
        font-weight: 400;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
        font-size: 0.8rem;
        padding: 8px 13px;
    }

    .card-image button:hover {
        opacity: 0.8;
    }

    .card-image button:active {
        transform: translateY(5px);
    }

    .card-image .drag-area {
        width: 100%;
        height: 180px;
        border-radius: 5px;
        border: 2px dashed #d5d5e1;
        color: #c8c9dd;
        font-size: 0.9rem;
        font-weight: 500;
        position: relative;
        background: #dfe3f259;
        display: flex;
        justify-content: center;
        align-items: center;
        user-select: none;
        -webkit-user-select: none;
        margin-top: 10px;
    }

    .card-image .drag-area .visible {
        font-size: 18px;
    }

    .card-image .select {
        color: #5256ad;
        margin-left: 5px;
        cursor: pointer;
        transition: 0.4s;
    }

    .card-image .select:hover {
        opacity: 0.6;
    }

    .card-image .container-image {
        width: 100%;
        height: auto;
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-wrap: wrap;
        max-height: 200px;
        overflow-y: auto;
        margin-top: 10px;
    }

    .card-image .container-image .image {
        width: calc(26% - 19px);
        margin-right: 15px;
        height: 75px;
        position: relative;
        margin-bottom: 8px;
    }

    .card-image .container-image .image img {
        width: 100%;
        height: 100%;
        border-radius: 5px;
    }

    .card-image .container-image .image span {
        position: absolute;
        top: -2px;
        right: 9px;
        font-size: 20px;
        cursor: pointer;
    }

    /* dragover class will used in drag and drop system */
    .card-image .drag-area.dragover {
        background: rgba(0, 0, 0, 0.4);
    }

    .card-image .drag-area.dragover .on-drop {
        display: inline;
        font-size: 28px;
    }

    .card-image input,
    .card-image .drag-area .on-drop,
    .card-image .drag-area.dragover .visible {
        display: none;
    }
</style>

<script>
    /**
     * Show Drag & Drop multiple image preview
     * 
     * @author Anuj Kumar
     * @link https://instagram.com/webtricks.ak
     * @link https://github.com/wtricks
     * */

    /** Variables */
    let files = [];
       
       
    let dragArea = document.querySelector('.drag-area'),
        input = document.querySelector('.drag-area input'),
        button = document.querySelector('.card button'),
        select = document.querySelector('.drag-area .select'),
        container = document.querySelector('.container-image');

    /** CLICK LISTENER */
    select.addEventListener('click', () => input.click());

    /* INPUT CHANGE EVENT */
    input.addEventListener('change', () => {
        let file = input.files;

        // if user select no image
        if (file.length == 0) return;

        for (let i = 0; i < file.length; i++) {
            if (file[i].type.split("/")[0] != 'image') continue;
            if (!files.some(e => e.name == file[i].name)) files.push(file[i])
        }

        showImages();
    });

    /** SHOW IMAGES */
    function showImages() {
        container.innerHTML = files.reduce((prev, curr, index) => {
            return `${prev}
		    <div class="image">
			    <span onclick="delImage(${index})">&times;</span>
			    <img src="${URL.createObjectURL(curr)}" />
			</div>`
        }, '');
        console.log(files);
    }

    /* DELETE IMAGE */
    function delImage(index) {
        files.splice(index, 1);
        showImages();
    }

    /* DRAG & DROP */
    dragArea.addEventListener('dragover', e => {
        e.preventDefault()
        dragArea.classList.add('dragover')
    })

    /* DRAG LEAVE */
    dragArea.addEventListener('dragleave', e => {
        e.preventDefault()
        dragArea.classList.remove('dragover')
    });

    /* DROP EVENT */
    dragArea.addEventListener('drop', e => {
        e.preventDefault()
        dragArea.classList.remove('dragover');

        let file = e.dataTransfer.files;
        for (let i = 0; i < file.length; i++) {
            /** Check selected file is image */
            if (file[i].type.split("/")[0] != 'image') continue;

            if (!files.some(e => e.name == file[i].name)) files.push(file[i])
        }
        showImages();
    });
</script>
@endsection