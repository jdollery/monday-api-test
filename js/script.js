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