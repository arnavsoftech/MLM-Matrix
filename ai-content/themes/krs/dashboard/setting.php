 <style type="text/css">
     .lbltxt {
         color: #be2222;
         margin-bottom: 0px;
     }

     @media (max-width: 768px) {
         span#div_1 {
             display: block;
             overflow: scroll;
         }
     }
 </style><!-- Earn-Account card -->
 <script>
     $(document).ready(function() {
         $(".btn-copy").click(function() {
             var id = $(this).attr('id');
             var el = document.getElementById(id);
             var range = document.createRange();
             range.selectNodeContents(el);
             var sel = window.getSelection();
             sel.removeAllRanges();
             sel.addRange(range);
             document.execCommand('copy');
             alert("Contents copied to clipboard.");
             return false;
         });
     });
 </script>

 <div class="row">
     <div class="col-sm-12">
         <div class="input-group mb-3">
             <div class="input-group-prepend">
                 <span class="input-group-text">Referral Code:</span>
             </div>
             <span class="form-control" id="div_1"><?= $user->ac_status == 1 ? site_url('signup/?ref=' . $user->username) : 'Upgrade your account to get referral link'; ?></span>
             <?php if ($user->ac_status == 1) { ?> <div class="input-group-append">
                     <span style="cursor: pointer; " class="input-group-text btn-copy" id="div_1" name="copy_pre">Copy</span>
                 </div><?php } ?>
         </div>
     </div>
 </div>