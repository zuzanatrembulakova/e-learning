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

async function removeTopic(){
    const form = event.target.form
    let conn = await fetch("apis/api-remove-topic.php", {
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

async function finishActivity(){
    const form = event.target.form
    let conn = await fetch("apis/api-finish-activity.php", {
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

async function sendQuestion(){
    const post = new FormData(event.target.form)
    let topicid = post.get('topicid')

    let conn = await fetch("apis/api-send-question.php", {
      method: "POST",
      body: post
    })
    
    let res = await conn.json()
    console.log(res)
    if( conn.ok ){ 
        if(post.get('teacherid')){
            location.href = "discussion.php?id=" + topicid + "&teacherID=" + post.get('teacherid')
        } else {
            location.href = "discussion.php?id=" + topicid
        }
    } else {
        alert(res['info'])
    }
}

async function gradeActivity(){
    const gradeForm = new FormData(event.target.form)
    let teacherid = gradeForm.get('teacherID')

    let conn = await fetch("apis/api-grade-activity.php", {
      method: "POST",
      body: gradeForm
    })
    let res = await conn.json()
    console.log(res)
    if( conn.ok ){ 
        location.href = "teacher-overview.php?id=" + teacherid
    } else {
        alert(res['info'])
    }
}

