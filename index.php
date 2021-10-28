<form action="add.php" method="post">
  <input type="text" name="name" id="name">
  <input type="email" name="email" id="name">
  <input type="submit" value="submit">
</form>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
  $(function () {

    $('form').on('submit', function (e) {

      e.preventDefault();

      $.ajax({
        type: 'post',
        url: 'add.php',
        data: $('form').serialize(),
        success: function () {
          alert('form was submitted');
        }
      });

    });

  });
</script>

<script>

let query = '{ boards (ids: 1843020011) { groups (ids: new_group) { items { id name } } } }';

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