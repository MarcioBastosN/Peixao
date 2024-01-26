function executa(){
    if("Notification" in window){
        let ask = Notification.requestPermission();
        ask.then(permission =>{
            if(permission === "granted"){
                let msg = new Notification("Sucesso",{
                        body:"Lançamento realizado",
                        icon:"./Isset/images/63_tucunare_acu_gd.jpg"
                });
            }
        });
    }
    return false;
}

function executaApdate(){
    if("Notification" in window){
        let ask = Notification.requestPermission();
        ask.then(permission =>{
            if(permission === "granted"){
                let msg = new Notification("Sucesso",{
                        body:"Atualização realizada",
                        icon:"./Isset/images/63_tucunare_acu_gd.jpg"
                });
            }
        });
    }
    return false;
}

function InformaDelete(){
    if("Notification" in window){
        let ask = Notification.requestPermission();
        ask.then(permission =>{
            if(permission === "granted"){
                let msg = new Notification("Sucesso",{
                        body:"Lançamento apagado",
                        icon:"./Isset/images/63_tucunare_acu_gd.jpg"
                });
            }
        });
    }
    return false;
}

function InformaCadastro(){
    if("Notification" in window){
        let ask = Notification.requestPermission();
        ask.then(permission =>{
            if(permission === "granted"){
                let msg = new Notification("Sucesso",{
                        body:"Cadastro efetuado com Sucesso",
                        icon:"./Isset/images/63_tucunare_acu_gd.jpg"
                });
            }
        });
    }
    return false;
}

function InformaDeletUser(){
    if("Notification" in window){
        let ask = Notification.requestPermission();
        ask.then(permission =>{
            if(permission === "granted"){
                let msg = new Notification("Sucesso",{
                        body:"Usuario apagado !",
                        icon:"./Isset/images/63_tucunare_acu_gd.jpg"
                });
            }
        });
    }
    return false;
}

function ClienteCadastrado(){
    if("Notification" in window){
        let ask = Notification.requestPermission();
        ask.then(permission =>{
            if(permission === "granted"){
                let msg = new Notification("Sucesso",{
                        body:"Cliente registrado",
                        icon:"./Isset/images/63_tucunare_acu_gd.jpg"
                });
            }
        });
    }
    return false;
}