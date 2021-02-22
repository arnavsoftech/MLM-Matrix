<div id="app" class="row">
    <div class="col-sm-6 m-auto">
        <h5>PIN Trasfer</h5>
        <hr>
        <form action="<?= site_url('dashboard/dotransfer'); ?>" method="post">
            <div class="box">
                <div class="box-p">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>PIN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $str = implode(':', $epins);
                            if (is_array($epins) && count($epins) > 0) {
                                $sl = 1;
                                foreach ($epins as $ob) {

                            ?>
                                    <tr>
                                        <td><?= $sl++; ?></td>
                                        <td><?= $ob; ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            <input type="hidden" name="pin" value="<?= $str; ?>">
                        </tbody>
                    </table>
                    <hr />
                    <div class="from-group row">
                        <div class="col-sm-8">
                            <input type="text" v-model="username" name="sponser" v-on:keyup="checkUsername()" required placeholder="Sponsor id" class="form-control form-control-sm">
                            <div v-if="success">{{ user.first_name }} {{ user.last_name }} - {{ user.mobile }}</div>
                            <div v-if="!success">{{ message }}</div>
                        </div>
                        <div class="col-sm-4">
                            <input type="submit" value="Done" class="btn btn-sm btn-block btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var vm = new Vue({
        el: '#app',
        data: {
            success: false,
            message: '',
            username: null,
            user: {
                first_name: '',
                last_name: '',
                mobile: ''
            }
        },
        methods: {
            checkUsername: function() {
                let url = AppUrl + 'userinfo';
                url += '/?username=' + this.username;
                if (this.username != '') {
                    fetch(url).then(ab => ab.json())
                        .then(resp => {
                            if (resp.status) {
                                let us = resp.data;
                                let user = {
                                    first_name: us.first_name,
                                    last_name: us.last_name,
                                    mobile: us.mobile
                                };
                                this.user = user;
                                this.success = true;
                            } else {
                                this.message = "Invalid Username ";
                            }
                        });
                }
            }
        }
    })
</script>