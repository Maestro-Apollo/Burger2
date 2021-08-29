<div class="sign_up">
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <?php if (isset($_SESSION['rname'])) { ?>
                <p class="text-light font-weight-bold m-0"><?php echo $_SESSION['rname']; ?></p>
                <small class="text-light"><i
                        class="fas fa-map-marker-alt mr-2"></i><?php echo $_SESSION['address']; ?></small>
                <?php } ?>
                <!-- <img src="images/Attachment_1597994185.png" class="w-50" alt=""> -->
            </div>
            <!-- <div class="col-md-6 col-12">
                <button class="btn btn-lg fav_btn font-weight-bold"><i class="fas fa-heart mr-2 heart"></i>Add to
                    Favorities</button>
            </div> -->
        </div>
    </div>
</div>