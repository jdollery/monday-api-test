<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monday Test Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-6 py-5">
          <h2 class="mb-4">Contact Us</h2>

          <div class="alert alert-success visually-hidden" role="alert" id="response"></div>

          <form id="contactForm">
            <div class="row mb-3">
              <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control">
              </div>
              <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

        </div>
      </div>
    </div>

    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      jQuery(document).ready(function(){

        jQuery('#contactForm').on('submit', function (e) {

          e.preventDefault();

          jQuery.ajax({
            type: 'post',
            url: 'contact.php',
            data: jQuery('form').serialize(),
            success: function (response) {
              jQuery("#response").html('Thank you for you message').addClass('alert-success').removeClass('visually-hidden');
              jQuery("form").trigger("reset");
            },
            error: function (response) {
              jQuery("#response").html(response).addClass('alert-danger').removeClass('visually-hidden');
            }
            
          });

        });

      });
    </script>

    <script>

    let query = '{boards(limit:1) { name id description items { name column_values { title id type text } } } }'; // get everything

    // let query = '{ boards (ids: 1843020011) { groups { id title } } }'; //get groups

    // let query = '{ boards (ids: 1843020011) { groups (ids: new_group) { items { id name status } } } }'; //get items in group

    fetch ("https://api.monday.com/v2", {
      method: 'post',
      headers: {
        'Content-Type': 'application/json',
        'Authorization' : 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjEzMDczOTQzNSwidWlkIjoyNTYwMzkzNywiaWFkIjoiMjAyMS0xMC0yOFQxNToyNTozNi41ODVaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTAyODg2NDQsInJnbiI6InVzZTEifQ.WFGKX3YYw25ylBZCt555aUbIRtqhRGJQF7DtRO7g4Dk'
      },
      body: JSON.stringify({
        query : query
      })
    })
      .then(res => res.json())
      .then(res => console.log(JSON.stringify(res, null, 2)));

    </script>

  </body>
</html>