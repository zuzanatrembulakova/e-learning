async function signin(){
    const form = event.target.form
    let conn = await fetch("api/api-signin.php", {
      method: "POST",
      body: new FormData(form)
    })
    let res = await conn.json()
    console.log(res)
    if( conn.ok ){ 
        location.href = "index.php" 
    } else {
        alert(res['info'])
    }
}

