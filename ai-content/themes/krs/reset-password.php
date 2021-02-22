<div class="body-inner">
    <section class="main-container" id="main-container">
        <div class="container py-5">
            <div class="row">
                <div class="col-sm-6 offset-sm-3 mt-4">
                    <div id="app">
                        <div class="box box-border p-3">
                            <h1 class="h4">Reset Password</h1>
                            <hr class="my-3" />
                            <p>Please enter your username.</p>
                            <div v-if="err" class="alert alert-danger">{{ errMsg }}</div>
                            <div class="mb-2">
                                <input type="text" v-model="username" placeholder="Username" class="form-control" />
                            </div>
                            <button type="button" v-on:click="sendPassword()" class="btn btn-sm btn-primary">{{ btnText }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var vm = new Vue({
        el: '#app',
        data: {
            err: true,
            errMsg: null,
            username: null,
            btnText: 'Send'
        },
        methods: {
            sendPassword: function() {
                if (!this.username) {
                    this.error = true;
                    this.errMsg = "Please fill username";
                    return;
                }
                let url = 'https://www.thesmartlife.in/home/call/reset/?mobile=' + this.username;
                fetch(url).then(ab => ab.json()).then(resp => {
                    this.errMsg = resp.message;
                    this.btnText = "Sent Successfully";
                });
            }
        }
    });
</script>