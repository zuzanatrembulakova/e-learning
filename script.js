async function signup(){
    let connection = await fetch("apis/api-signup.php", {
        method : "POST",
        body : new FormData(document.querySelector("#form_sign_up"))
    })
    
    let response = await connection.json()
    console.log(response)
    if( connection.ok ) { 
        location.href = "choose-topic.php" 
    } else {
        alert(response['info'])
    }
}

async function signin(){
    const form = event.target.form
    let conn = await fetch("apis/api-signin.php", {
      method: "POST",
      body: new FormData(form)
    })
    let res = await conn.json()
    console.log(res)
    if( conn.ok ){ 
        location.href = "overview.php" 
    } else {
        alert(res['info'])
    }
}

async function chooseTopic(){
    const form = event.target.form
    let conn = await fetch("apis/api-choose-topic.php", {
      method: "POST",
      body: new FormData(form)
    })
    let res = await conn.json()
    console.log(res)
    if( conn.ok ){ 
        location.href = "overview.php" 
    } else {
        alert(res['info'])
    }
}



function displayInput() {
    document.querySelector("#your-question").style.display = "block"
}

