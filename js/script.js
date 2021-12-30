// let query = '{ boards (limit:10) { name id description items { name column_values { title id type text } } } }'; // get everything

// let query = '{ boards { name id board_folder_id } }'; // get boards

// let query = '{ boards (ids: XXXXXXXXXX) { groups { id title } } }'; //get groups

// let query = '{ boards (ids: 2087111809) { groups (ids: new_group) { items { id name status } } } }'; //get items in group

// let query = '{ boards (ids: 263429360) { groups { id title } } }'; //get small groups

// let query = '{ boards (ids: 263429360) { groups (ids: new_group) { items { id name } } } }'; //get small in-progress

// let query = '{ boards (ids: 343787892) { groups { id title } } }'; //get large groups

// let query = '{ boards (ids: 343787892) { groups (ids: q2) { items { id name } } } }'; //get large q2 (Waiting list)

// let query = '{ boards (ids: 2049882160) { groups (ids: topics) { items { id name column_values { title id type text } } } } }'; //get Synergy

let query = '{ boards (ids: 2087111809) { groups { id title } } }'; //get api test groups

fetch ("https://api.monday.com/v2", {
  method: 'post',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjkxMTE0ODcyLCJ1aWQiOjE2MTEyNjIsImlhZCI6IjIwMjAtMTEtMTdUMDg6NTQ6MTguMDAwWiIsInBlciI6Im1lOndyaXRlIiwiYWN0aWQiOjY4NzIwMCwicmduIjoidXNlMSJ9.HzchYQXCp7uUXjgaweircZbnKI-BB2n38S9A-OvH4Qs',
  },
  body: JSON.stringify({
    query : query
  })
})

.then(res => res.json())
.then(res => console.log(JSON.stringify(res, null, 2)));