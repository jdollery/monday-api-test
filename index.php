<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monday Test API Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
    <style>

      pre {
        white-space: break-spaces;
      }

    </style>
  
  </head>
  <body>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-6 py-5">
          <h2 class="mb-4">API Test Form</h2>
          <p>Date and time now: <?php echo date("Y-m-d H:i:s") ?></p>

          <div class="alert alert-success visually-hidden" role="alert" id="message"></div>

          <form id="apiForm" method="post" enctype="multipart/form-data" action='push.php'>
            <div class="row mb-3">
              <div class="col-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" required >
              </div>
              <div class="col-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required >
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="status">
                  <option selected disabled required >Select a status</option>
                  <option value="1">Done</option>
                  <option value="2">Stuck</option>
                  <option value="0">Working on it</option>
                </select>
              </div>
              <div class="col-6">
                <label for="treatment" class="form-label">Treatment</label>
                <select class="form-select" name="treatment" id="treatment" required >
                  <option selected disabled >Select a treatment</option>
                  <option value="Hygiene">Hygiene</option>
                  <option value="Whitening">Whitening</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="upload" class="form-label">Upload</label>
                <input type="file" id="upload" name="upload" class="form-control">
              </div>
              <!-- <div class="col-12">
                <label for="update" class="form-label">Update</label>
                <textarea class="form-control" id="update" rows="3"></textarea>
              </div> -->
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

        </div>

        <!-- <h5 class="mt-5 mb-4">Board data:</h5>
        <pre class="border border-1 p-4 rounded" id="board"></pre> -->

      </div>
    </div>

    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      jQuery(document).ready(function(){

        jQuery('#apiForm').on('submit', function (e) {

          e.preventDefault();

          // var formData = new FormData(this);
          var form_data = jQuery(this).serializeArray(),
          form_url = '/' + jQuery(this)[0].action.split('/').pop();

          jQuery.ajax({
            type: 'post',
            // url: 'push.php',
            url: form_url,
            // data: jQuery('form').serialize(),
            data: form_data,
            encode: true,
            success: function (response) {
              console.log("ID:", response);
              jQuery("#message").html("Thank you for your enquiry.").addClass('alert-success').removeClass('visually-hidden');
              jQuery("form").trigger("reset");
            },
            error: function (response) {
              console.error("Error:", response);
              jQuery("#message").html("Sorry, there was an issue. Please try again.").addClass('alert-danger').removeClass('visually-hidden');
            }
            
          });

        });

        jQuery.ajax({
          type: "GET",
          url: "get.php",
          // dataType: 'JSON',
          success: function(response){
            // jQuery("#board").html(response);
            console.log(response);
            // console.log(JSON.stringify(response, null, '\t'))
          },
          error: function (response) {
            // jQuery("#board").html(response);
            console.error(response);
          }

        });
        
      });
    </script>

  </body>
</html>