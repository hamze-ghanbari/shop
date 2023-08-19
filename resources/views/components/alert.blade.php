<div class="toast-box d-none overflow-hidden position-fixed bg-white__default rounded p-2">
    <section class="toast-side rounded"></section>
    <section class="content d-flex align-items-center p-1">
        <span class="toast-icon flex-center ms-1  white__default rounded-circle">
            <i class="fa-solid"></i>
        </span>
        <section class="d-flex flex-wrap">
            <span class="body-copy-strong w-100 toast-title"></span>
            <span class="caption-medium gray toast-content"></span>
        </section>
    </section>
    <span class="pointer toast-close">
            <i class="fa-solid fa-close gray__shade-3"></i>
        </span>
</div>
<script type="text/javascript">

    function toastSuccess(content, time = 5000) {
        showToast('موفقیت', 'check', content, time);
    }

    function toastError(content, time = 5000) {
        showToast('خطا', 'close', content, time);
    }

    function toastWarning(content, time = 5000) {
        showToast('هشدار', 'warning', content, time);
    }

    function toastInfo(content, time = 5000) {
        showToast('اطلاعات', 'info', content, time);
    }

    let timeOut;
    function showToast(title, icon, content, time) {
        clearTimeout(timeOut);
        $('.toast-title').html(title);
        $('.toast-content').html(content);
        let toastSideColor = '';
        switch (icon) {
            case 'check' :
                toastSideColor = 'bg-green__default';
                break;
            case 'close' :
                toastSideColor = 'bg-red__default';
                break;

            case 'warning' :
                toastSideColor = 'bg-orange__default';
                break;

            case 'info' :
                toastSideColor = 'bg-primary__default';
                break;
        }
        $('.toast-side').removeClass('bg-green__default bg-red__default bg-orange__default bg-primary__default').addClass(toastSideColor);
        $('.toast-icon').removeClass('bg-green__default bg-red__default bg-orange__default bg-primary__default').addClass(toastSideColor)
            .children('i').removeClass(`fa-close fa-warning fa-info fa-check`).addClass(`fa-${icon}`);

        $('.toast-box').removeClass('d-none').addClass('d-flex');

         timeOut = setTimeout(function () {
            $('.toast-box').removeClass('d-flex').addClass('d-none');
            $('.toast-side').removeClass(toastSideColor);
            $('.toast-title').html();
            $('.toast-content').html();
        }, time);
    }

    $('.toast-close').click(function(){
        $('.toast-box').removeClass('d-flex').addClass('d-none');
        $('.toast-title').html();
        $('.toast-content').html();
        clearTimeout(timeOut);
    });

</script>
