<main class="modal-box bg-white__default d-none flex-wrap align-content-between p-3">
    <div class="col-12 header-modal d-flex align-items-center">
    <span class="confirm-icon white__default rounded-circle d-flex align-items-center justify-content-center">
        <i class="fa-solid"></i>
    </span>
        <div class="d-flex flex-wrap me-2">
            <h6 class="body-copy-medium" id="confirm-title"></h6>
            <p class="caption-light" id="confirm-content"></p>
        </div>
    </div>
    <div class="col-12 footer-modal d-flex align-items-center justify-content-between">
        <button class="btn confirm-btn text-center bg-green__default white__default" id="confirmed">تایید</button>
        <button class="btn confirm-btn text-center bg-red__shade-3 white__default" id="canceled">لغو</button>
    </div>
</main>

<script type="text/javascript">
    function confirmModal(title, content, callback, confirmIcon = 'warning'){
        $(".modal-box").removeClass('d-none').addClass('d-flex');
        $("#confirm-title").text(title);
        $("#confirm-content").text(content);
        let confirmIconColor;
        switch (confirmIcon) {
            case 'check' :
                confirmIconColor = 'bg-green__default';
                break;
            case 'warning' :
                confirmIconColor = 'bg-red__shade-3';
                break;
            case 'info' :
                confirmIconColor = 'bg-primary__default';
                break;
        }

        $('.confirm-icon').addClass(confirmIconColor).children('i').addClass(`fa-${confirmIcon}`);

        $("#confirmed").click(function (){
            $('.modal-box').removeClass('d-flex').addClass('d-none');
            callback(true);
        });

        $("#canceled").click(function (){
            $('.modal-box').removeClass('d-flex').addClass('d-none');
        });
    }

</script>
