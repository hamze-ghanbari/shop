<button type="submit"
        class="submit-btn btn bg-green__default white__default small-copy-medium mt-4 col-12 col-sm-6 flex-center">
    <span class="content">
      {{$content}}
    </span>
    <i class="fa-solid fa-spinner loading d-none"></i>
</button>

<script type="text/javascript">
    function showLoading() {
        $('button.submit-btn').prop('disabled', true);
        $('button.submit-btn .content').addClass('d-none');
        $('i.loading').removeClass('d-none');
    }

    function hideLoading() {
        $('button.submit-btn').prop('disabled', false);
        $('button.submit-btn .content').removeClass('d-none');
        $('i.loading').addClass('d-none');
    }
</script>
