async function signin(){
    const form = event.target.form
    let conn = await fetch("apis/api-signin.php", {
      method: "POST",
      body: new FormData(form)
    })
    let res = await conn.json()
    console.log(res)
    if( conn.ok ){ 
        location.href = "choose-topic.php" 
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

