

         
            <section class="confirmation">
                <label class="failed" for="" >Payment Failed</label>
                <!-- <label class="failed" for="" >Failed</label> -->
                <small>Error while processing your payment</small>
            </section>
            
            <div class="h-seperator"></div>
            
            <?php if(isset($_REQUEST['error_msg'])) : ?>
            <section>
                <div class="error"><?php echo $_REQUEST['error_msg']?></div>
            </section>
            <div class="h-seperator"></div>
            <?php endif; ?>

           

            <div class="h-seperator"></div>

