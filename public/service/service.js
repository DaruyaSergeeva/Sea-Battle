function registration(login,password,nickname){
    const params = new URLSearchParams();
    params.append('method','registration');
    params.append('login',login);
    params.append('password',password);
    params.append('nickname',nickname);
   
    const promise = axios.post('http://SeaBattle/api/index.php', params);
    return promise.then((response) =>{
        return response.data;
    });
}

function checkCombination(){
    const params = new URLSearchParams();
    params.append('method','checkcombination');
   
    const promise = axios.post('http://SeaBattle/api/index.php', params);
    return promise.then((response) =>{
        return response.data;
    });
}


function login(login,password){
    const promise = axios.get('http://SeaBattle/api/index.php?method=login&login='+login+'&password='+password);
    return promise.then((response) =>{
        return response.data;
    });
}

function logout(token){
    const promise = axios.get('http://SeaBattle/api/index.php?method=logout&token=' + token);
    return promise.then((response) =>{
        return response.data;
    });
}

//for admin
function getUserByToken(token){
    const promise = axios.get('http://SeaBattle/api/index.php?method=getuserbytoken&token='+token);
    return promise.then((response) =>{
        return response.data;
    });
}

function getAllTables(){
    const promise = axios.get('http://SeaBattle/api/index.php?method=getalltables');
    return promise.then((response) =>{
        return response.data;
    });
}

function getTableById(id){
    const promise = axios.get('http://SeaBattle/api/index.php?method=gettablebyid&id='+id);
    return promise.then((response) =>{
        return response.data;
    });
}

function createTable(token, name, password){
    const promise = axios.get('http://SeaBattle/api/index.php?method=createtable&token=' + token + '&name=' + name + '&quantplayers=' + 2 + '&password=' + password);
    return promise.then((response) =>{
        return response.data;
    });
}

function connectToTable(token,id){
    const promise = axios.get('http://SeaBattle/api/index.php?method=connecttotable&token=' + token + '&id=' + id);
    return promise.then((response) =>{
        return response.data;
    });
}

function disconnectFromTable(token,id){
    const promise = axios.get('http://SeaBattle/api/index.php?method=disconnectfromtable&token=' + token + '&id=' + id);
    return promise.then((response) =>{
        return response.data;
    });
}

//for admin
function deleteTableById(id){
    const promise = axios.get('http://SeaBattle/api/index.php?method=deletetablebyid&id='+id);
    return promise.then((response) =>{
        return response.data;
    });
}
