<h5>Repurchase</h5>
<hr>
<style>
    .applymore {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<div class="row">
    <div class="col-md-6 m-auto">
        <div class="box p-3">
            <div class="row">
                <div class="col-sm-8">
                    <input type="text" placeholder="Search by id" class="form-control" id="idsearch">
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-primary btn-block btn-search">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
            <div id="result"></div>
        </div>
    </div>
</div>
<script>
    var baseUrl = '<?= site_url('dashboard'); ?>';
    var code = '<?= $code; ?>';
    $(document).ready(() => {
        $('.btn-search').click(() => {
            let v = $('#idsearch').val();
            let link = baseUrl + `/applypurchase/?code=${code}&userid=${v}`;
            $.getJSON('<?= site_url('dashboard/ajax_get_name/?userid=') ?>' + v, (data) => {
                console.log(data);
                let msg = null;
                if (data.success) {
                    msg = `<div class="text-success pt-2 border-top mt-3 applymore">
                    <span>${ data.first_name } ${ data.last_name } ( ${ data.mobile } )</span>
                    <a href="${ link }" class="btn btn-apply btn-xs btn-warning">APPLY NOW</a>
                    </div>`;
                } else {
                    msg = '<div class="text-danger pt-2 border-top mt-3">NO RECORD FOUND</div>';
                }
                $('#result').html(msg);
            })
        });
        $('.btn-apply').click((e) => {
            e.preventDefault();
            console.log(e);
        });
    });
</script>