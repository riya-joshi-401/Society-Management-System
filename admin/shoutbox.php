<?php include './includes/shared/header.php'; ?>
<?php include './includes/shared/sidebar.php'; ?>
<?php include './includes/shared/topbar.php'; ?>

<?php //SELECT shoutbox.FlatID, ShoutBoxID, Chat, FlatNumber, BlockNumber from shoutbox inner join flats on shoutbox.FlatID=flats.FlatID;
 
 
 ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title text-info">Shoutbox</h4>
                    <section class="sb-container container shadow rounded border border-secondary">
                        <header class="sb-header rounded-top d-flex align-items-center">
                            <div class="mr-2 d-lg-inline profile-icon-parent"> <i class="fas fa-user fa-fw"></i></div>
                            <div style="font-size:1.5rem;">
                                <?php echo $_SESSION['username']; ?>
                            </div>
                        </header>
                        <div class="text-container-sb">
                            <!-- <div class="chat-outgoing align-items-center">
                                <div class="details">
                                    <p>This is a dummy message.This is a dummy message. This is a dummy message.
                                        This is
                                        a dummy message. </p>
                                </div>
                            </div>
                            <div class="chat-incoming flex-column">
                                <div class="msger">
                                    A-202, timestamp
                                </div>
                                <div class="details align-items-center">
                                    <p>This is a dummy message. This is a dummy message. This is a dummy message.
                                        This
                                        is a dummy message.</p>
                                </div>
                            </div>
                            <div class="chat-outgoing align-items-center">
                                <div class="details">
                                    <p>This is a dummy message.This is a dummy message. This is a dummy message.
                                        This is
                                        a dummy message. </p>
                                </div>
                            </div>
                            <div class="chat-incoming flex-column">
                                <div class="msger">
                                    A-202, timestamp
                                </div>
                                <div class="details align-items-center">
                                    <p>This is a dummy message. This is a dummy message. This is a dummy message.
                                        This
                                        is a dummy message.</p>
                                </div>
                            </div>
                            <div class="chat-incoming flex-column">
                                <div class="msger">
                                    A-202, timestamp
                                </div>
                                <div class="details align-items-center">
                                    <p>This is a dummy message. This is a dummy message. This is a dummy message.
                                        This
                                        is a dummy message.</p>
                                </div>
                            </div>
                            <div class="chat-incoming flex-column">
                                <div class="msger">
                                    A-202, timestamp
                                </div>
                                <div class="details align-items-center">
                                    <p>This is a dummy message. This is a dummy message. This is a dummy message.
                                        This
                                        is a dummy message.</p>
                                </div>
                            </div> 
                            <div class="chat-outgoing flex-column">
                                <div class="msger">
                                    A-202, timestamp
                                </div>
                                <div class="details">
                                    <p>This is a dummy message.This is a dummy message. This is a dummy message.
                                        This is
                                        a dummy message. </p>
                                </div>
                            </div>-->
                        </div>
                        <form action="" class="typing-area">
                            <input type="text" placeholder="Type a message...." name="shout-msg" id="shout-msg">
                            <input type="hidden" name="shout-owner" id="shout-owner"
                                value="<?php echo $_SESSION['username'];?>">
                            <button type="submit" name="submit-shout" id="submit-shout"><i class="fa fa-telegram">
                                </i></button>
                        </form>
                    </section>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<script>
$(document).ready(function() {
    $('#submit-shout').on('click', function(
        e) { //function to insert msg into the database
        e.preventDefault();
        var name = $('#shout-owner').val();
        var shout = $('#shout-msg').val();
        var date = getDate();
        var datastring = 'name=' + name + "&shout=" + shout + '&date=' +
            date;
        console.log(datastring);
        if (shout === "") {
            alert("Please write a message");
        } else {
            console.log('shoutmsg:', shout);
            console.log('shout by:', name);
            $.ajax({
                type: "POST",
                url: "includes/handlers/shoutbox.php",
                data: datastring,
                cache: false,
                success: function(html) {
                    $('.text-container-sb').append(html);
                    $('#shout-msg').val("");
                    console.log(
                        "Admin message stored in the db");
                }
            })
        }

        return false;
    });
});

function getDate() { //function to get the timestamp
    var date;
    date = new Date();
    date = date.getUTCFullYear() + '-' +
        ('00' + (date.getUTCMonth() + 1)).slice(-2) + '-' +
        ('00' + date.getUTCDate()).slice(-2) + ' ' +
        ('00' + date.getUTCHours()).slice(-2) + ':' +
        ('00' + date.getUTCMinutes()).slice(-2) + ':' +
        ('00' + date.getUTCSeconds()).slice(-2);
    return date;
}


//function to load messages using ajax
chatbox = document.querySelector(".text-container-sb");
setInterval(function() {
    var name = $('#shout-owner').val();
    var datastring = 'name=' + name;

    $.ajax({
        type: "POST",
        url: "includes/handlers/load_messages.php",
        data: datastring,
        cache: false,
        success: function(data) {
            // console.log(data);
            chatbox.innerHTML = data;
            // console.log(chatbox);

        }
    })

}, 500);
</script>


<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>