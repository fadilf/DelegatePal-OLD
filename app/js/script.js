var DelegatePal = angular.module("DelegatePal",['oc.lazyLoad']);
var folderid;
var transcend;
var d = document;
var w = window;
var clickdown = d.getElementById("clickdown");
DelegatePal.controller("control",function($scope,$http,$ocLazyLoad){
    function refresh(){
        $http.post("json.php").then(function(json){
            $scope.json = json.data;
            if(json.data === "0") w.location = "../";
        });
    }
    $scope.refresh = function() {
        refresh();
    }
    refresh();
    $scope.title = "Notebooks";
    $scope.modalTitle = "";
    $scope.modalContext = "";
    $scope.modalContent = "";
    $scope.modalVisible = false;
    $scope.bottomClick = false;
    $scope.urlprefix = "";
    $scope.entered = false;
    $scope.modalClick = false;
    $scope.bloc = false;
    $scope.logOut = function(){
        $http.post("submit.php",{
            function: "logout"
        }).success(function(data){
            location.reload();
        });
    }
    $scope.hideModal = function(){
        if(!$scope.modalClick){
            $scope.modalVisible=false;
            $scope.modalTitle='';
            $scope.modalContext='';
            $scope.modalContent='';
        } else $scope.modalClick = false;
    }
    $scope.open = function(page){
        $scope.title = page;
    }
    $scope.newNote = function(){
        $scope.modalTitle = "New Note";
        $scope.modalContent = "";
        $scope.modalVisible = true;
        $scope.notename = "";
        $scope.notetype = "text";
        $scope.available = true;
        Dropzone.autoDiscover = false;
        $scope.require = function(){
            setTimeout(function(){
                var drop = d.getElementById('drop');
                if(drop){
                    var droparea = new Dropzone("div#drop", { url: "submit.php"});
                    droparea.options.dropzone = {
                        maxFilesize: 8,
                        maxFiles: 1,
                        acceptedFiles: "image/*,.mp3,.pdf"
                    }
                    droparea.on("addedfile", function(file){
                        if(file.size > 8388608){
                            alert("File exceeds 8MB limit.");
                            droparea.removeAllFiles(true);
                            droparea.removeAllFiles();
                        } else if(file.type !== "application/pdf" && file.type !== "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && file.type.indexOf("image/") === -1){
                            droparea.removeAllFiles(true);
                            droparea.removeAllFiles();
                            alert("Accepted file types are PDFs, Word Documents and images only.");
                        }
                    });
                    droparea.on("sending", function(file, xhr, formData) {
                        formData.append("notename", d.getElementById("notename").value);
                        formData.append("foldernum", $scope.folderid);
                        formData.append("bloc", $scope.bloc);
                    });
                    droparea.on("success",function(file){
                        $scope.modalTitle = "Note Created!";
                        $scope.modalContent = "The note has been created!";
                        $scope.$apply();
                        setTimeout(function(){
                            $scope.hideModal();
                            refresh();
                            $scope.$apply();
                        },3000);
                    });
                }
            },0);
        }
        $scope.require();
        $scope.createNote = function(notename, notetype, noteURL){
            if(notename == undefined || notename.length == 0){
                alert("Note name not given.");
            } else if (!$scope.available){
            } else {
                $scope.available = false;
                var notedata;
                switch(notetype){
                    case "text":
                        notedata = "";
                        break;
                    case "file":
                        alert("File not given.");
                        break;
                    case "url":
                        notedata = noteURL;
                        break;
                }
                if(notetype != "file"){
                    $http.post("submit.php",{
                        function: "newnote",
                        note: notename,
                        type: notetype,
                        data: notedata,
                        bloc: $scope.bloc,
                        foldernum: $scope.folderid
                    }).success(function(data){
                        if(data != "1"){
                            alert(data);
                            $scope.available = true;
                        }
                        refresh();
                        $scope.hideModal();
                    });
                }
            }
        }
    }
    $scope.openFolder = function(index){
        if(!$scope.bottomClick){
            $scope.title = "Notes";
            $scope.folderindex = index;
            $scope.folderid = $scope.json.folders[index].id;
            folderid = $scope.folderid;
            $scope.bloc = false;
            $ocLazyLoad.load(['js/textAngular-rangy.min.js', 'js/textAngular-sanitize.min.js', 'js/textAngular.min.js']);
        } else $scope.bottomClick = false;
    }
    $scope.openBloc = function(index){
        if(!$scope.bottomClick){
            $scope.title = "Notes";
            $scope.folderindex = index;
            $scope.folderid = $scope.json.blocs[index].id;
            folderid = $scope.folderid;
            $scope.bloc = true;
        } else $scope.bottomClick = false;
    }
    $scope.openNote = function(id){
        var blc = $scope.bloc;
        if(!$scope.bottomClick){
            if(!blc) $scope.noteinfo = $scope.json.folders[$scope.folderindex].notes[id];
            else $scope.noteinfo = $scope.json.blocs[$scope.folderindex].notes[id];
            var noteid = $scope.noteinfo.id;
            transcend = $scope.noteinfo;
            if($scope.noteinfo.type==="pdf"){
                var renderurl = "render.php/preview.pdf?id="+noteid+"&bloc="+blc;
                $scope.title = "Note";
                setTimeout(function(){
                    d.getElementById("pdfpreview").src = encodeURI(renderurl);
                },100);
            } else if($scope.noteinfo.type==="word"){
                $http.get("userhash.php").then(function(json){
                    var addr = String(w.location);
                    addr = addr.substr(0,addr.lastIndexOf("/")+1);
                    var hash = encodeURI(json.data.hash);
                    var renderurl = "render.php/preview.docx?hash="+hash+"*userid="+json.data.id+"*id="+noteid+"*bloc="+blc;
                    renderurl = "https://view.officeapps.live.com/op/view.aspx?src=" + encodeURI(addr) + renderurl;
                    $scope.title = "Note";
                    setTimeout(function(){
                        d.getElementById("pdfpreview").src = renderurl;
                    },100);
                });
            } else if($scope.noteinfo.type==="image"){
                $scope.title = "Note";
            } else {
                $http.get("json.php?noteid="+noteid+"&bloc="+blc).then(function(json){
                    if(!blc){
                        $scope.json.folders[$scope.folderindex].notes[id] = json.data;
                        $scope.noteinfo = json.data;
                    } else {
                        $scope.json.blocs[$scope.folderindex].notes[id] = json.data;
                        $scope.noteinfo = json.data;
                    }
                    $scope.title = "Note";
                    if($scope.noteinfo.type==="url"){
                        var pr1 = "HTTP://";
                        var pr2 = "HTTPS://";
                        var comp = $scope.noteinfo.data.toUpperCase();
                        if(comp.indexOf(pr1)===0 || comp.indexOf(pr2)===0) $scope.urlprefix = "";
                        else $scope.urlprefix = "http://";
                    }
                });
            }
        } else $scope.bottomClick = false;
    }
    $scope.closeNote = function(){
        var nd = $scope.noteinfo;
        if(nd.name.length > 30)
            alert("Title longer than 20 characters.");
        else if((["text","url"].indexOf(nd.type)!==-1)&&(nd.data.length>16777215))
            alert("Content too long.");
        else {
            var optionarray = {
                function: "notedata",
                id: nd.id,
                bloc: $scope.bloc,
                name: nd.name
            }
            if(nd.type == "url"||nd.type == "text")
                optionarray.data = nd.data;
            $http.post("submit.php",optionarray).success(function(data){
                if(data == "0"){
                    alert("Error");
                }
                refresh();
                $scope.title = "Notes";
            });
        }
        $scope.title = "Notes";
    }
    $scope.newFolder = function(){
        $scope.foldername = "";
        $scope.modalTitle = "New Binder";
        $scope.modalContent = "";
        $scope.modalVisible = true;
        $scope.createFolder = function(foldername){
            if(foldername == undefined || foldername.length == 0){
                alert("Folder name not given.");
            } else {
                $http.post("submit.php",{
                    function: "newfolder",
                    name: foldername
                }).success(function(data){
                    if(data == "Reached folder limit for user."){
                        alert("Too many folders.");
                    } else if(data != "1"){
                        alert("Error while creating folder.");
                    }
                    refresh();
                    $scope.hideModal();
                });
            }
        }
    }
    $scope.newBloc = function(){
        $scope.modalTitle = "New Bloc";
        $scope.modalContent = "";
        $scope.modalVisible = true;
        $scope.createBloc = function(blocname){
            if(blocname == undefined || blocname.length == 0){
                alert("Bloc name not given.");
            } else {
                $http.post("submit.php",{
                    function: "newbloc",
                    name: blocname
                }).success(function(data){
                    if(data != "1"){
                        alert("Error while creating bloc.");
                    }
                    refresh();
                    $scope.hideModal();
                });
            }
        }
    }
    $scope.joinBlocModal = function(){
        $scope.modalTitle = "Join Bloc";
        $scope.modalContent = "";
        $scope.modalVisible = true;
        $scope.joinBloc = function(referralcode){
            if(referralcode.length != 6){
                alert("Invalid referral code.");
            } else {
                $http.post("submit.php",{
                    function: "joinbloc",
                    code: referralcode
                }).success(function(data){
                    if(data != "1"){
                        alert("Error while joining bloc or invalid code.");
                    }
                    refresh();
                    $scope.hideModal();
                });
            }
        }
    }
    $scope.mashFolder = function(){
        $scope.step = 1;
        $scope.guide = "Select the notes you would like to export and then hit continue.";
        $scope.title = "Mash";
        var folder;
        if($scope.bloc)
            folder = $scope.json.blocs[$scope.folderindex];
        else
            folder = $scope.json.folders[$scope.folderindex];
        var selected = [], docs = [];
        $scope.check = function(index){
            var note = d.getElementsByClassName("mash")[index];
            if(note.className.includes("checked")){
                note.className = note.className.replace(/ checked/g,"");
                selected.splice(selected.indexOf(folder.notes[index].id), 1);
            } else {
                note.className += " checked";
                selected.push(folder.notes[index].id);
                selected.sort();
            }
        }
        $scope.extraFiles = function(){
            $scope.step = 2;
            $scope.guide = "Select extra files provided by DelegatePal to assist you.";
            $scope.checkDoc = function(index){
                var doc = d.getElementsByClassName("mash")[index-1];
                if(doc.className.includes(" checked")){
                    doc.className = doc.className.replace(/ checked/g,"");
                    docs.splice(docs.indexOf(index), 1);
                } else {
                    doc.className += " checked";
                    docs.push(index);
                    docs.sort();
                }
            }
        }
        $scope.downloadMerged = function(){
            $scope.modalTitle = "Mash Binder";
            $scope.modalVisible = true;
            var mashlink = "merge.php?notes=" + selected.toString() + "&docs=" + docs.toString() + "&bloc=" + $scope.bloc;
            setTimeout(function(){
                var downloadc = d.getElementById("filedownload");
                downloadc.innerHTML = "<a class='filedownload' href='" + mashlink + "' target='_blank'>Download</a>";
            },0);
        }
    }
    $scope.downloadFolder = function(index){
        $scope.bottomClick = true;
        $scope.modalVisible = true;
        $scope.modalTitle = "Binder Download";
        var folder = $scope.json.folders[index];
        if(folder.notes.length){
            $scope.modalContent = "Loading...";
            $ocLazyLoad.load("js/jszip.min.js").then(function(){
                var zip = new JSZip();
                var loaded = 0;
                function download(requesturl,filename){
                    $http.get(requesturl,{responseType:"arraybuffer"}).then(function(file){
                        zip.file(filename, file.data);
                        loaded++;
                        if(folder.notes.length==loaded){
                            var file = zip.generate();
                            $scope.modalContent = "";
                            var downloadc = d.getElementById("filedownload");
                            downloadc.innerHTML = "<a href='data:application/zip;base64," + file + "' class='filedownload' download='archive.zip'>Download</a>";
                        }
                    });
                }
                for(var i=0;i<folder.notes.length;i++){
                    var note = folder.notes[i];
                    var extension = "";
                    switch(note.type){
                        case "text":
                            extension = ".txt";
                            break;
                        case "url":
                            extension = ".html";
                            break;
                        case "image":
                            var data = note.preview;
                            var strpos = data.indexOf(";base64,");
                            extension = "."+data.substr(11,strpos-11);
                            break;
                        case "word":
                            extension = ".docx";
                            break;
                        case "pdf":
                            extension = ".pdf";
                            break;
                        case "audio":
                            extension = ".mp3";
                    }
                    var filename = note.name+extension;
                    var requesturl = "render.php/" + filename + "?zip=true&id=" + note.id;
                    download(requesturl,filename);
                }
            });
        } else {
            $scope.modalContent = "Folder empty.";
        }
    }
    $scope.deleteFolderModal = function(index){
        $scope.foldername = $scope.json.folders[index].name;
        $scope.bottomClick = true;
        $scope.modalTitle = "Delete Binder";
        $scope.modalVisible = true;
        $scope.deleteFolder = function(){
            $http.post("submit.php",{
                function: "deletefolder",
                foldernum: $scope.json.folders[index].id
            }).success(function(data){
                if(data === "1") {
                    refresh();
                    $scope.modalTitle = $scope.foldername + " Deleted";
                    $scope.modalContent = "The binder " + $scope.foldername + " has been deleted.";
                } else alert("Error while deleting binder");
            });
        }
    }
    $scope.editFolderModal = function(index){
        $scope.bottomClick = true;
        $ocLazyLoad.load(['js/tinycolor.min.js','js/angularjs-color-picker.min.js']).then(function(){
            $scope.foldername = $scope.json.folders[index].name;
            $scope.foldercolor = $scope.json.folders[index].color;
            $scope.modalTitle = "Edit Binder";
            $scope.modalVisible = true;
            $scope.editFolder = function(foldername,foldercolor){
                $http.post("submit.php",{
                    function: "editfolder",
                    folderid: $scope.json.folders[index].id,
                    foldername: foldername,
                    foldercolor: foldercolor
                }).success(function(data){
                    if(data === "1") {
                        refresh();
                        $scope.hideModal();
                    } else alert("Error while renaming folder");
                });
            }
        });
    }
    $scope.deleteBlocModal = function(index){
        $scope.blocname = $scope.json.blocs[index].name;
        if(!$scope.json.blocs[index].moderator)
            return;
        $scope.bottomClick = true;
        $scope.modalTitle = "Delete Bloc";
        $scope.modalVisible = true;
        $scope.deleteBloc = function(){
            $http.post("submit.php",{
                function: "deletebloc",
                blocnum: $scope.json.blocs[index].id
            }).success(function(data){
                if(data === "1") {
                    refresh();
                    $scope.modalTitle = $scope.blocname + " Deleted";
                    $scope.modalContent = "The bloc " + $scope.blocname + " has been deleted.";
                } else alert("Error while deleting bloc.");
            });
        }
    }
    $scope.leaveBlocModal = function(index){
        $scope.blocname = $scope.json.blocs[index].name;
        if($scope.json.blocs[index].moderator)
            return;
        $scope.bottomClick = true;
        $scope.modalTitle = "Leave Bloc";
        $scope.modalVisible = true;
        $scope.leaveBloc = function(){
            $http.post("submit.php",{
                function: "leavebloc",
                blocnum: $scope.json.blocs[index].id
            }).success(function(data){
                if(data === "1") {
                    refresh();
                    $scope.modalTitle = $scope.blocname + " left";
                    $scope.modalContent = "The bloc " + $scope.blocname + " has been left.";
                } else alert("Error while leaving bloc.");
            });
        }
    }
    $scope.downloadBloc = function(index){
        $scope.bottomClick = true;
        $scope.modalVisible = true;
        $scope.modalTitle = "Bloc Download";
        var folder = $scope.json.blocs[index];
        if(folder.notes.length){
            $scope.modalContent = "Loading...";
            $ocLazyLoad.load("js/jszip.min.js").then(function(){
                var zip = new JSZip();
                base64 = {base64: true};
                var loaded = 0;
                function download(requesturl,filename){
                    $http.get(requesturl,{responseType:"arraybuffer"}).then(function(file){
                        zip.file(filename, file.data);
                        loaded++;
                        if(folder.notes.length==loaded){
                            var file = zip.generate();
                            $scope.modalContent = "";
                            var downloadc = d.getElementById("filedownload");
                            downloadc.innerHTML = "<a href='data:application/zip;base64," + file + "' class='filedownload' download='archive.zip'>Download</a>";
                        }
                    });
                }
                for(var i=0;i<folder.notes.length;i++){
                    var note = folder.notes[i];
                    var extension = "";
                    switch(note.type){
                        case "text":
                            extension = ".txt";
                            break;
                        case "url":
                            extension = ".html";
                            break;
                        case "image":
                            var data = note.preview;
                            var strpos = data.indexOf(";base64,");
                            extension = "."+data.substr(11,strpos-11);
                            break;
                        case "word":
                            extension = ".docx";
                            break;
                        case "pdf":
                            extension = ".pdf";
                            break;
                        case "audio":
                            extension = ".mp3";
                    }
                    var filename = note.name+extension;
                    var requesturl = "render.php/" + filename + "?zip=true&id=" + note.id + "&bloc=true";
                    download(requesturl,filename);
                }
            });
        } else {
            $scope.modalContent = "Bloc empty.";
        }
    }
    $scope.showRefCode = function(index){
        $scope.blocName = $scope.json.blocs[index].name;
        $scope.refcode = $scope.json.blocs[index].refcode;
        $scope.modalContext = "Referral Code";
        $scope.bottomClick = true;
        $scope.modalTitle = $scope.blocName + " Referral Code";
        $scope.modalVisible = true;
    }
    $scope.editBlocModal = function(index){
        $scope.bottomClick = true;
        $ocLazyLoad.load(['js/tinycolor.min.js','js/angularjs-color-picker.min.js']).then(function(){
            $scope.blocname = $scope.json.blocs[index].name;
            $scope.bloccolor = $scope.json.blocs[index].color;
            if(!$scope.json.blocs[index].moderator)
                return;
            $scope.modalTitle = "Edit Bloc";
            $scope.modalVisible = true;
            $scope.editBloc = function(blocname,bloccolor){
                $http.post("submit.php",{
                    function: "editbloc",
                    blocid: $scope.json.blocs[index].id,
                    blocname: blocname,
                    bloccolor: bloccolor
                }).success(function(data){
                    if(data === "1") {
                        refresh();
                        $scope.hideModal();
                    } else alert("Error while renaming bloc");
                });
            }
        });
    }
    $scope.deleteNoteModal = function(index){
        if(!$scope.bloc)
            var nd = $scope.json.folders[$scope.folderindex].notes[index];
        else
            var nd = $scope.json.blocs[$scope.folderindex].notes[index];
        $scope.notename = nd.name;
        $scope.bottomClick = true;
        $scope.modalTitle = "Delete Note";
        $scope.modalVisible = true;
        $scope.deleteNote = function(){
            $http.post("submit.php",{
                function: "deletenote",
                bloc: $scope.bloc,
                noteid: nd.id
            }).success(function(data){
                if(data === "1") {
                    refresh();
                    $scope.modalTitle = $scope.notename + " Deleted";
                    $scope.modalContent = "The note " + $scope.notename + " has been deleted.";
                } else alert("Error while deleting note");
            });
        }
    }
    $scope.editNoteModal = function(index){
        if(!$scope.bloc)
            var nd = $scope.json.folders[$scope.folderindex].notes[index];
        else
            var nd = $scope.json.blocs[$scope.folderindex].notes[index];
        $scope.notename =   nd.name;
        $scope.bottomClick = true;
        $scope.modalTitle = "Edit Note";
        $scope.modalVisible = true;
        $scope.editNote = function(notename){
            $http.post("submit.php",{
                function: "renamenote",
                bloc: $scope.bloc,
                noteid: nd.id,
                notename: notename
            }).success(function(data){
                if(data === "1") {
                    refresh();
                    $scope.hideModal();
                } else alert("An error occured while editing the note.");
            });
        }
    }
    $scope.accountPage = function(){
        $scope.title = "Account";
        $scope.menuVisible = false;
        $scope.userName = $scope.json.name;
        $scope.userUsername = $scope.json.username;
        $scope.userEducation = $scope.json.profile.education;
        $scope.userMuns = $scope.json.profile.muns;
        $scope.userAwardswon = $scope.json.profile.awardswon;
        $scope.oldPass = "";
        $scope.newPass = "";
        $scope.confirmPass = "";
        $scope.newpicModal = function(){
            $scope.modalTitle = "Profile Picture";
            $scope.modalVisible = true;
            setTimeout(function(){
                var picdrop = d.getElementById("picdrop");
                if(picdrop){
                    var dropzone = new Dropzone("div#picdrop", { url: "submit.php"});
                    dropzone.options.dropzone = {
                        maxFilesize: 8,
                        maxFiles: 1,
                        acceptedFiles: "image/png,image/jpeg,image/gif"
                    }
                    dropzone.on("addedfile",function(file){
                        if(file.size > 8388608){
                            alert("File exceeds 8MB limit.");
                            dropzone.removeAllFiles(true);
                            dropzone.removeAllFiles();
                        } else if(file.type.indexOf("image/png") === -1 && file.type.indexOf("image/jpeg") === -1 && file.type.indexOf("image/gif") === -1){
                            dropzone.removeAllFiles(true);
                            dropzone.removeAllFiles();
                            alert("JPGs, PNGs and GIFs only.");
                        }
                    });
                    dropzone.on("sending", function(file, xhr, formData) {
                        formData.append("profilepic", true);
                    });
                    dropzone.on("success",function(file){
                        $scope.hideModal();
                        refresh();
                    });
                }
            },0);
        }
        $scope.userDetails = function(name, username, education, muns, awardswon){
            $http.post("submit.php",{
                function: "userdetails",
                name: name,
                username: username,
                education: education,
                muns: muns,
                awardswon: awardswon
            }).success(function(data){
                if(data === "1") {
                    alert("User info successfully changed!");
                    refresh();
                    $scope.title = "Notebooks";
                } else alert(data);
            });
        }
        $scope.newPassword = function(oldPass, newPass, confirmPass){
            if(newPass !== confirmPass) alert("New passwords don't match.");
            else {
                $http.post("submit.php",{
                    function: "newpassword",
                    oldpassword: oldPass,
                    newpassword: newPass
                }).success(function(data){
                    if(data === "1") {
                        alert("Password changed!");
                        $scope.title = "Notebooks";
                    } else alert(data);
                });
            }
        }
    }
    $scope.searchPage = function(){
        $scope.title = "Research Tool";
        $scope.query = "";
        $scope.sval = "";
        var plain, country, ngo, solutions, un, sval;
        function setSVGs(){
            plain = '<path id="path15" d="M150.75 223.06l-5.4-.57-1.73-2.07c7.6-7.1 12.7-16.82 13.8-27.86 2.6-24.6-15.2-46.63-39.8-49.22-24.6-2.58-46.6 15.26-49.2 39.86-2.6 24.6 15.3 46.65 39.9 49.23 11.1 1.16 21.6-1.82 30.1-7.7l1.7 2.1-.5 5.42 30.7 37.8 11.3-9.15-30.6-37.9zm-41.1-4.32c-17.07-1.8-29.4-17.02-27.6-34.08 1.8-17.06 17-29.4 34.07-27.6 17.1 1.8 29.4 17.02 27.6 34.08-1.8 17.07-17 29.4-34 27.6z"/>',
                country = '<path fill="#262262" d="M.03 216.4l97.26-62.84 44.64 69.12-97.26 62.86z"/><path fill="#434B60" d="M94.8 143.6c2.5-1.6 5.1-1.9 5.9-.7l4.2 6.5 76.8 118.9c.8 1.2-.6 3.5-3.1 5.1-2.5 1.6-5.1 1.9-5.9.7l-76.8-119-4.2-6.5c-.7-1.2.6-3.4 3.1-5z"/><circle cx="73.3" cy="220.3" r="27.9" fill="#7FABDA"/><path fill="#1B9172" d="M72.1 192.7c.1-.1.1-.2.2-.3-5 .2-10 1.7-14.5 4.7-4.9 3.3-8.5 7.8-10.5 12.9.1.1.2.2.3.2 3.9 2.4 9.8 6.8 14.1 5.8 2.1-.5 3.5-1.8 5.7-2 .2 0 .6 0 .8.1 1.6.7 2.3 2.7 3.4 2.6.9-.1 1.7.4 1.9 1.2.7 3.5 3.8 6 7.8 6.4 2.8.3 3.6 4.8 3.9 8.6.1 1.4 1.8 1.8 2.7.8 1.3-1.7 2.1-3.5 2.8-6 1-3.6 0-6.1 1.2-9.3v-.1c-.6-2.1-1.2-7.1-3.7-6.9-2.3.3-4.7-1.9-7.6-2.6-.3-.1-.7 0-1 .2-2.2 1.1-4.2.2-4.9 2.1-.5 1.5-2 1.8-3.2.8-.4-.3-.8-.6-1.7-.3-.7.2-1.4-.3-1.6-1-.2-.9-1.7.2-2.4.9-.2.2 0-1.2-.2-.9-.6 1.2-2.4 1-3.1-.1-.7-1.2-.5-1.3 1.3-2.8 1.5-2.4 2.9-2.3 4.5.1 1.4-.7 1.5-1.5.2-2.6-.4-.3-.6-.8-.5-1.3.2-4.8 1.3-7.5 4.1-11.2z"/>',
                ngo = '<path fill="#262262" d="M.03 216.4l97.26-62.84 44.64 69.12-97.26 62.86z"/><path fill="#434B60" d="M94.8 143.6c2.5-1.6 5.1-1.9 5.9-.7l4.2 6.5 76.8 118.9c.8 1.2-.6 3.5-3.1 5.1-2.5 1.6-5.1 1.9-5.9.7l-76.8-119-4.2-6.5c-.7-1.2.6-3.4 3.1-5z"/><path fill="#75CFF2" d="M70.7 193.8c-3.5 2.1-6.2 5.9-6.9 10-.1.5-.4.9-.8 1.2-.4.3-1 .3-1.4.1-3.9-1.4-8.5-.9-12 1.1-6.4 3.8-8.5 11.7-4.7 18.1 4.8 8.1 15.8 10.6 34.9 14.4h.1l3.6.9.9-3.6v-.1c6-18.5 9.2-29.4 4.5-37.5-3.8-6.3-11.8-8.4-18.2-4.6zm-17.2 17.1c-4 2.3-5.3 7.3-2.9 11.3.5.8.2 1.9-.6 2.4s-1.9.2-2.4-.6c-3.3-5.6-1.5-12.7 4.2-16 .8-.5 1.9-.2 2.4.6.4.8.2 1.8-.7 2.3z"/><path d="M69 190.8c-3.9 2.3-6.8 6.1-8.1 10.5-4.4-1-9.2-.3-13.1 2-8.1 4.7-10.7 14.8-5.9 22.9 2.7 4.5 7.1 7.8 13.9 10.3 6 2.2 13.4 3.7 23.2 5.7l5.2 1.3c.5.1.9 0 1.3-.2s.7-.6.8-1l1.4-5.2c3.1-9.5 5.4-16.8 6.4-23.1 1.1-7.2.4-12.7-2.2-17.2-4.8-8.1-14.8-10.8-22.9-6zM84.4 236v.1l-.9 3.6-3.6-.9h-.1c-19.1-3.7-30.2-6.3-34.9-14.4-3.8-6.4-1.7-14.4 4.7-18.1 3.5-2.1 8.1-2.5 12-1.1.5.2 1 .1 1.4-.1.4-.3.7-.7.8-1.2.7-4.1 3.3-7.9 6.9-10 6.4-3.8 14.4-1.7 18.1 4.7 4.8 8 1.6 18.8-4.4 37.4z" class="c"/><path d="M51.8 207.9c-5.6 3.3-7.5 10.3-4.2 16 .5.8 1.5 1.1 2.4.6.8-.5 1.1-1.5.6-2.4-2.3-4-1.1-8.9 2.9-11.3.8-.5 1.1-1.5.6-2.4-.4-.7-1.5-.9-2.3-.5z" class="c"/>',
                solutions = '<path fill="#262262" d="M.03 216.4l97.26-62.84 44.64 69.12-97.26 62.86z"/><path fill="#434B60" d="M94.8 143.6c2.5-1.6 5.1-1.9 5.9-.7l4.2 6.5 76.8 118.9c.8 1.2-.6 3.5-3.1 5.1-2.5 1.6-5.1 1.9-5.9.7l-76.8-119-4.2-6.5c-.7-1.2.6-3.4 3.1-5z"/><path d="M54.6 190.3c-.6.4-.8 1.1-.4 1.7l2.7 4.2c.4.6 1.1.8 1.7.4.6-.4.8-1.1.4-1.7l-2.7-4.2c-.3-.6-1.1-.8-1.7-.4zm41.4 9.5l-4.2 2.7c-.6.4-.8 1.1-.4 1.7.4.6 1.1.8 1.7.4l4.2-2.7c.6-.4.8-1.1.4-1.7-.3-.6-1.1-.8-1.7-.4zM49.3 229l-4.2 2.7c-.6.4-.8 1.1-.4 1.7.4.6 1.1.8 1.7.4l4.2-2.7c.6-.4.8-1.1.4-1.7-.3-.6-1.1-.8-1.7-.4zm27.4-41.8l-1.1 4.9c-.2.7.3 1.3.9 1.5.3.1.7 0 .9-.2.3-.2.5-.4.6-.8l1.1-4.9c.2-.7-.3-1.3-.9-1.5-.6-.1-1.3.4-1.5 1zm-12.3 53.7l-1.1 4.9c-.2.7.3 1.3.9 1.5.3.1.7 0 .9-.2s.5-.4.6-.8l1.1-4.9c.2-.7-.3-1.3-.9-1.5s-1.4.3-1.5 1zm31.5-19.8c-.7-.2-1.3.3-1.5.9-.2.7.3 1.3.9 1.5l4.9 1.1c.3.1.7 0 .9-.2.3-.2.5-.4.6-.8.2-.7-.3-1.3-.9-1.5l-4.9-1zm-53.7-12.3c-.7-.2-1.3.3-1.5.9-.2.7.3 1.3.9 1.5l4.9 1.1c.3.1.7 0 .9-.2.3-.2.5-.4.6-.8.2-.7-.3-1.3-.9-1.5l-4.9-1zm18.4-9c-9.4 5.9-12.2 18.2-6.3 27.6 4.7 7.5 13.6 10.8 21.7 8.8l6.5 10.4 2.1-1.3 2 3.2 6.4-4-2-3.2 2.1-1.3-6.5-10.4c5.4-6.5 6.3-15.9 1.6-23.4-5.9-9.4-18.2-12.3-27.6-6.4z" class="c"/><path fill="#F6E5A0" d="M60.2 225.1c-.6.4-1.4.2-1.7-.4-4.4-7-2.3-16.3 4.8-20.7.6-.4 1.4-.2 1.7.4.4.6.2 1.4-.4 1.7-5.8 3.7-7.6 11.4-4 17.2.4.7.2 1.5-.4 1.8z"/><path fill="#566181" d="M77.9 239.2l4.6 7.4 2.1-1.3 2 3.1 6.4-3.9-2-3.2 2.1-1.4-4.6-7.4"/>',
                un = '<path fill="#262262" d="M.03 216.4l97.26-62.84 44.6 69.12-97.3 62.86z"/><path fill="#434B60" d="M94.8 143.6c2.5-1.6 5.1-1.9 5.9-.7l4.2 6.5 76.8 118.9c.8 1.2-.6 3.5-3.1 5.1-2.5 1.6-5.1 1.9-5.9.7l-76.8-119-4.2-6.5c-.7-1.2.6-3.4 3.1-5z"/><g class="c"><path d="M102.5 222.82c-1.62 1.7-3.6 3.1-5.07 4.86 1.54-4.64-1.18-8.76-1-13.25.14-1.33.12-2.62.4-3.96.26 3.37 2.83 6.4 2.87 9.8.03 1.35-.2 2.8-.65 4.14.28-.1.4-.6.55-.9.96-3.8 3.73-6.4 5.16-9.9.54-1.4.84-3.1.6-4.6 1.9 4.3.16 10.5-2.85 13.9zm-1.03-21.4c-.2 2.38-.67 4.8-.74 7.17-.68-1.5-1.52-3.2-2.83-4.2-2.57-2.2-5.05-4.6-7.13-7.4l-.66-1.2c2.6 2.7 6.9 3 8.8 6.5.6.8.8 1.6 1.1 2.5h.1l.1-.3c-.6-2-1.4-3.9-1.6-5.9-.4-2.9-.5-6-2.6-8.4 3.5 2.3 5.6 6.9 5.8 11z" class="c"/><path d="M89.1 185.04c3.62 1.5 6.63 5.53 7.03 9.5.25 1.64.72 3.27 1.37 4.83-.26-.18-.5-.5-.74-.73-2.6-2.54-6.77-3-9.66-5.13-.94-.7-1.83-1.5-2.62-2.3 2.67 1.6 6.5.9 8.88 3 .73.5 1.2 1.3 1.84 1.9.05 0 .06-.1.04-.1-1.96-2.4-3.5-5.3-4.7-8.1-.88-1.4-1.84-2.7-3.3-3.3.68 0 1.26.4 1.86.7z" class="c"/><path d="M87.4 185.36c1.92 2.04 2.56 4.8 4.46 6.9v.03c-2.83-1.8-6.26-1.4-9.37-2.3-1.9-.6-3.2-1.7-4.4-3.1 2.6 1.9 5.9.8 8.8 1.9.8.1 1.4.7 2.1 1.1v-.1c-2.2-1.5-3.9-3.6-5.9-5.4-.9-.8-2.2-1.3-3.4-1.4 2.4-.9 5.7.2 7.4 2.1z" class="c"/><path d="M78.26 183.45c2.54.48 4.42 1.94 6.1 3.63l.65.47c-3.4-.3-6.9-1.3-9.9-2.8l-3-.78c2.1-.28 4.1-.94 6.3-.52zM39.23 204.1c-.78 2.46-.83 5-1.02 7.43-.2 2.02-1.1 3.77-1.7 5.7-.1-1.8-1.1-3.5-.9-5.35 0-3.2 2-5.54 3.7-7.77z" class="c"/><path d="M33.22 214.6c.2-1.5.8-2.78 1.77-3.78-1.4 2.87.4 5.53 1.1 8.24.2.98.3 1.98.7 2.96l.1.03c-.2-1.2-.2-2.53.2-3.8.7-2.4 2.5-4.73 1.9-7.35 1.7 3.02.6 6.88-.7 10-.5 1.47-.9 3.03-.7 4.47-.6-.72-.8-1.57-1.4-2.37-1.9-2.46-3.8-5.34-3.1-8.4z" class="c"/><path d="M34.1 226.26c-1.68-2.6-1.86-5.44-1.5-8.37.03-.1 0-.2.1-.2-.14 3.6 3.24 6 4.92 9l1.6 3.1c.03 0 .1.1.14 0-.1-.4-.3-.8-.43-1.2-1.08-2.7 0-5.7.85-8.5.12-.7.2-1.3.1-2 .6 1.3.94 2.7 1.1 4.2.25 3.6-1.02 7.6.43 11.1-2-3-5.5-4-7.3-7.4z" class="c"/><path d="M35.07 230.82c-.3-.95-.68-1.9-.77-2.87 1.42 3.92 5.3 5.04 7.9 7.6 1 .95 1.8 2.13 2.93 2.93.04 0 .06-.06.07-.12-3.1-2.55-3.24-6.54-3.08-10.1 0-.93-.23-1.84-.5-2.75 1.05 1.4 1.7 3.3 2.4 5 .75 2.2 1.25 4.4 1.84 6.6.36 1.4 1.25 2.7 2.16 3.8h-.23c-2.6-1.5-6.1-1.8-8.3-3.8-1.8-1.6-3.6-3.6-4.5-6z" class="c"/><path d="M39.08 237.75c2.5 3.56 7.7 3.13 11.4 5.1.82.36 1.64.83 2.52 1-.32-.34-.9-.45-1.27-.77-1.43-.9-2.6-2.32-3.37-3.95-.97-2-1.24-4.25-2.74-6.06 3.75 2.54 5.9 7.23 9.1 10.5.72.68 1.66 1.14 2.46 1.74-4.7-.2-10.6.3-14.6-2.9-1.48-1-2.63-2.8-3.48-4.5z" class="c"/><path d="M46.22 245.1c4.4 3.1 9.3.66 14 1.34.87.16 1.76.24 2.6.16v-.06c-1.1-.2-2.38-.45-3.4-1-3.36-1.45-4.86-5.4-7.9-7.33 2.16.8 4.23 1.7 6 2.9 2.78 2.1 5.1 5 8.95 5.5-3.36.8-6.5 3-10 2.8-3.73 0-7.84-1.4-10.2-4.2z" class="c"/><path d="M55.76 250.1c5.04 1.6 9.25-2.47 13.78-3.97.6-.27 1.27-.35 1.8-.8-.65-.02-1.3.42-1.97.46-3.8.7-6.27-2.4-9.35-3.6 3.04.1 6.02 1 9.15 1.6 2.2.4 4.27-.1 6.33-.8-.33.4-.94.7-1.35 1.1-2.8 2.7-5.65 6.3-9.82 7.2-2.7.6-6.1.2-8.58-1.3z" class="c"/><path d="M101.2 233.6c-2.62 3.3-6.93 4.1-10.76 3.7-1.47-.06-3-.46-4.32.45-.5.3-.97.62-1.3 1 3.25-.36 6.64-.14 10.08.66-.1.7-.36 1.4-.6 2-3.46-1-7.08-1.8-10.43-1.5-.46.4-.76 1-1.1 1.5-1.3 2.6-2.36 5.6-2.68 8.7l-2.1-.3c.8-3.4 2.2-6.6 4.1-9.4-3.1.8-3.5 3.9-4.8 6.2-1.3 3-4.2 5.7-7.5 6.2-1.8.4-3.8.4-5.6-.3 3 .2 6.3-1.6 8.2-4 2.4-3.4 4.7-7.2 9.2-8.7.6-.3 1.6-.1 1.8-1 2.5-2.5 6.1-4 9.5-4.2l3.2-.5c2.9-.5 5.9-2.7 7.1-5.4-.3 2-1.2 3.8-2.4 5.3z" class="c"/><path d="M102.72 227.95c-2.93 3.72-7.8 4.25-11.78 5.84l-.76.3c1.5-1.5 2.85-3 3.5-5.1.85-3.2 1.45-6.3 2.8-9.2-.4 3.1 1.27 6.3-.67 9.4-.4.8-1.2 1.4-1.7 2.2 1-.6 1.7-1.5 2.7-2.2 3.4-2.8 8-4.8 8.7-9.5.4 2.8-.9 6-2.7 8.1zm.48-14.8c-.9 1.87-1.88 3.7-2.65 5.68l-.1-.14c.02-5-4.07-9.4-5.14-14.3l-.3-1.7c1.3 2.7 3.6 4.1 5.1 6.7.9 1.5 1.2 3.2 1.1 4.9l.2-.1c.2-2.1.2-4.1.6-6.2.9-3.1 1.7-6.2.4-9 3.3 3.9 3.2 9.3 1 13.9z" class="c"/></g><g class="c"><path d="M70.88 219.6l.7-.4 10.23 17.04-.6.4m-15-16.52l.8.2-4.8 19.3-.7-.2m1.5-22.15l.4.7-17 10.2-.4-.67M62.6 213l-.2.8-19.3-4.84.2-.78m22.32 1.1l-.66.4L54.7 192.6l.66-.4m14.62 16.64l-.75-.2 4.82-19.3.78.2m-1.25 22.3l-.4-.68L90.2 200.9l.4.67M73.7 216.5l.2-.77 19.3 4.8-.2.78" class="d"/><path d="M64.4 193.6c11.5-2.12 22.57 5.5 24.7 17 2.12 11.5-5.5 22.57-17 24.68-11.48 2.14-22.55-5.45-24.68-16.98-2.13-11.5 5.47-22.57 16.98-24.7zm.17.9c11-2.03 21.6 5.24 23.63 16.24 2.04 11-5.23 21.6-16.23 23.62-11 2.04-21.6-5.23-23.62-16.22-2.04-11 5.23-21.6 16.22-23.63z" class="d"/><path d="M65.3 198.4c8.85-1.67 17.37 4.2 19.03 13.07 1.66 8.87-4.2 17.4-13.08 19.04-8.87 1.7-17.4-4.2-19.04-13-1.6-8.8 4.3-17.4 13.1-19zm.16.9c8.37-1.56 16.42 3.98 17.96 12.33 1.55 8.36-4 16.4-12.34 17.96-8.36 1.5-16.4-4-17.96-12.4-1.55-8.4 4-16.4 12.34-18z" class="d"/><path d="M66.14 203.02c6.3-1.18 12.38 3 13.54 9.3 1.18 6.33-3 12.4-9.3 13.56-6.32 1.17-12.4-3-13.55-9.3-1.18-6.33 3-12.4 9.3-13.56zm.15.84c5.8-1.1 11.4 2.78 12.5 8.63 1.1 5.8-2.8 11.4-8.7 12.5-5.9 1.1-11.5-2.8-12.6-8.7-1.1-5.9 2.8-11.5 8.6-12.6z" class="d"/><path d="M67.1 208.22c3.43-.65 6.73 1.63 7.38 5.06.64 3.43-1.64 6.73-5.07 7.37-3.4.65-6.7-1.63-7.3-5.06-.6-3.5 1.7-6.8 5.1-7.4zm.18.9c2.95-.55 5.76 1.4 6.3 4.33s-1.4 5.77-4.34 6.3c-2.93.54-5.76-1.4-6.3-4.33-.54-2.94 1.4-5.77 4.34-6.3z" class="d"/><path d="M67 188.38c14.62-.56 27.05 10.67 27.72 25.07.7 14.4-10.62 26.52-25.23 27.08-14.7.56-27.1-10.67-27.8-25.07-.7-14.4 10.6-26.52 25.2-27.08zm.06.94c14.1-.53 26.05 10.3 26.72 24.16.67 13.86-10.24 25.56-24.3 26.08-14.1.54-26.07-10.28-26.74-24.15-.67-13.8 10.23-25.5 24.32-26z" class="d"/><path d="M87.84 217.02c.08.1.2.42.3.45.12.06.33-.1.4-.18.2-.3.24-.8.2-1.1.02-.2 0-.4-.13-.5l-.4-.4c-.1-.2-.4-.5-.6-.4v-.3c-.1-.2-.5 0-.5.3 0 .1.1.2.2.3.1.2.3.6.3.8.1.2 0 .5.1.7.1.1.3.1.5 0zm-12.48 5.52l.15.1.1.05c.3 0 .3-.5 0-.4h-.1s-.1 0-.1.1zm-.02-.45c-.04.1-.04.2.2.2l-.2-.3zm-4.05-.4c-.1.2-.2.1-.2.2-.1.1 0 .1 0 .2 0 0-.1.1 0 .2h.2l.4-.4c0-.2-.1-.2-.1-.3v-.2c-.1-.2-.4-.1-.5 0zm6.3-4.8l.1.2.1.2c.2-.2.3-.4.5-.6 0-.1.1-.2.2-.2s.1.1.1.1l-.1.5c-.1.3-.4.5-.5.9-.1.2 0 .3-.1.5 0 .2-.1.3-.2.4 0 .1.1.1 0 .2l-.1-.2c-.1 0-.2.1-.3 0s-.1-.2-.2-.2c-.1-.2-.3-.6-.3-.7 0-.1.1-.2.2-.3v.1c.1 0 .2-.1.2-.2.1-.1.1-.4.1-.6l-.3.3v-.8zm-5.9 4.4c0 .2.1 0 .3.1l.1.1-.2.1v.1l-.1.2.4-.1c-.2.1-.2.2-.3.4l.4-.3c.2-.2.5-.2.6-.5l-.1-.3h-.3l-.2-.2-.5-.2-.1.1c0-.2.1-.5-.2-.4h-.1v-.2l-.3.3c0 .2.1.4.3.4zm-2-3l.1.1-.1-.1.1.3c.1.1.2-.1.3-.2 0-.1 0-.2-.1-.2l-.2-.1h-.2l-.1-.1h-.1zm-18.4 13.1c.2.3.3.2.5.5.1.1.1.2.4.5.1.1.2.2.4.1-.3-.4-.5-.6-.8-.9l-.6-.4h-.1zm29.9-23.3c-.1.1-.1.2 0 .3 0 .1.2.1.3 0 .1-.2-.1-.6-.4-.4zm-22.1 13.2c0 .1.1.3.2.3-.1-.1-.2-.3-.3-.3zm7-4.1h.1c.1-.3 0-.4.1-.6 0-.2.1-.2.1-.3 0-.1 0-.1-.1-.2 0-.1 0-.2-.1-.4s-.3-.3-.4-.2l-.1-.1-.2.2v.3c0 .2-.2.3-.2.4v.2c-.1.2-.3.2-.3.3-.1.1-.2.4-.2.5-.1.2 0 .3 0 .5 0 0 0 .1.1.1 0 0 .1 0 .1-.1s.2-.3.2-.4h.2l.2-.1c.1-.1.2 0 .2 0 .2 0 .2-.2.2-.4v-.1zm-1-1.9H65l.03-.1zm.3 0c.1.1.4.1.6.2v-.2c-.1-.2-.2-.4-.4-.4-.1 0-.2.1-.2.1l-.1-.1c-.3-.1-.3.6 0 .3zm-1.2.3c.2 0 .2.1.5-.1 0 .1 0 .5-.2.5s-.2-.1-.3-.1c-.1 0 0 .2 0 .2 0 .2-.2.3 0 .6v-.1c.2.1.2-.2.3-.3v.1s.1.1.2 0v-.4l.1-.2.2-.3c.1-.3.1-.2 0-.5-.1-.1 0-.1-.1-.1-.3-.2-.5.2-.5.2h-.2l-.2.2zm1-.7l-.1.1c.1-.1.2-.2.1-.4-.1.1-.2.1-.1.2zm-7 4.9l.2.5.2.2.3.4c0-.2-.1-.5-.1-.7l-.1-.2c0-.2-.1-.2-.2-.3l-.1.2-.2-.3zm7.2-5.2c-.1-.2-.1-.2 0-.2l-.2-.3c-.1 0-.2.1-.2.2-.1.1 0 .3.2.2zm-.9.1h.1c.1-.2.2-.2.4-.2l-.1-.1v-.2c.1-.1.1-.2-.1-.3h-.1c-.4 0-.3.2-.3.4v.2zm.5-.5l.1-.1c0-.1-.2-.3-.3-.3s-.1.1-.1.1l.1.1h.1zm-7 5.2c0-.2-.1-.3-.2-.5-.1.2 0 .3.1.4zm-.1-2l.3.6v.9l-.1-.1c0 .2.2.5.3.6 0-.2-.1-.4-.1-.6-.1-.4 0-.8-.2-1.2 0-.1-.2-.4-.3-.5zm21.7-12.1c0-.3-.2-.7-.2-.9-.2-.6-.1-1-.6-1.6-.1-.2-.3-.4-.5-.3-.3.1 0 .4 0 .5.1 0 .1.1.1.1.1.3.3.5.4.8l.5.9.3.3zm-6.2-1.8s.1 0 .1.1h.1c.2 0 .2-.2.1-.3h-.2c-.1 0-.1 0-.2.1zm3.2-2.5c.1.2.4.5.6.6l.4.2.7.6c0-.3-.2-.4-.3-.6-.3-.3-.7-.5-1-.7-.2-.1-.3-.3-.5-.3zm-1.5.4l.1.3-.4.1c.1.1.3.3.5.4h.3c.3 0 .6.1.9.2.3.1.3.2.4.2 0 0 .1 0 .2-.1 0-.1-.1-.2-.1-.3v-.2c-.1-.2-.3-.3-.4-.4l-.4-.3c-.2-.1-.3-.2-.5-.3-.3-.1-.4 0-.7.1h-.3zm-6.3 4.2c0 .1.1.2 0 .4h-.2l.1.3c0 .1.1.3.1.4.1.1.2 0 .3-.2v-.4c0-.3.1-.5 0-.7l-.3.1zm6.7-5.2l.4.2c.1.1.1.1.2 0-.1-.1-.6-.3-.7-.3zm-9.1 7.1c-.3.1.1.3.1.4 0 .1-.2.5-.3.5-.1.1-.1.1-.2.1h-.3l-.2.5c0 .1-.1.2-.2.3 0 0-.1.1-.1.2s.1.2.2.2l.2.1c-.2.2-.1.3.1.5.1.1.4.5.5.5.1.1.3.1.4.1.1 0 .2-.1.3-.1l-.2-.3.1-.1.2.2.1-.1.3-.1h.1s.1.2.1.3c.1.1.3 0 .4-.1l.2.2c.1.1 0 .2.3.3.1 0 .2.1.3 0 0-.1.1-.3.2-.5.1.1.1.1.2.1v.1l.1-.3c.2.4 0 .4-.1.7 0 .1.1.2.2.4h.1v-.2c.2-.2.2.2.2.2 0 .1.1.1.1 0v.2l.2.1-.4.3c-.2.1-.3.4-.4.6v.1h.1l-.3.4c.1-.1.3-.2.4-.3 0-.1.1-.1.2-.2h.1v.1l.6-.2c.2 0 .2-.1.3-.2.2 0 .2.1.4.1.2-.1.3-.3.4-.4l-.1.3.2.1.2-.2c-.1.3-.2.1-.5.4l.4-.1c.1 0 .1-.1.3-.1.1-.1.4-.1.3-.3h.3c.1-.1.4-.1.4.1v.1l-.2-.1c-.2-.1-.4.1-.6.2l-.4.1-.3.2c-.2.1-.3.1-.4.1-.1 0-.1.1-.1.1 0 .1.1.1.13.1h.4c.17 0 .2-.1.3-.1h.1c.1-.1.07-.1.2-.2l.2-.1-.3.4-.33.1c.1.1.2.1.17.3l-.1-.08v.5c0 .1-.1.2-.1.2-.1.1-.2 0-.3 0-.18 0-.2.02-.3.13.2.1.2.07.4 0 .1 0 .5.1.6.1v.1c0 .1.2.3.3.3h.2l-.1.4c.1 0 .12-.1.3 0l-.2.1-.5-.05c.2 0 .36-.2.4-.3.17-.2-.1-.4-.3-.4-.1 0-.2.1-.3.1-.1 0-.3.1-.4.1l-.2.2v-.1c-.1 0-.1 0-.14.1-.18-.1-.2-.1-.3 0l.04.1-.2-.1.1.1h-.3l.3.3v.1c0 .2.1.4.2.5.2.3.2.4.3.6.1.2.2.2.3.5.1.1.1.4.1.5v.6c0 .1.1.1.1.14.1.1 0 .1.3.2v.2h.1c0 .2.2.3.3.1.1-.1.1-.3.1-.45l.6.3c.1.02.2.12.3.1.1 0 .1-.18.1-.3 0-.1.1-.1.1-.2 0-.2-.2-.3-.3-.4v-.3c-.1-.2-.3-.2-.4-.2-.1 0-.2-.1-.3-.2-.2-.3-.1-.4-.2-.7-.1-.2-.2-.2-.3-.3 0-.1-.1-.2 0-.2.2-.15.3 0 .4.14l.1.28c.1.1.1.2.2.3.1.1.2.1.2.1.1.1.2.1.3.1h.3c.1-.1.1-.4.1-.5.1-.1.2-.1.2-.2v.4c0 .1-.2.2-.1.4s.3 0 .4.2c.1.1-.2.1-.2.3 0 .2.2.2.3.3l.1.23c0 .2-.2.2-.2.3-.1.1-.1.3-.2.4-.1.1-.2.1-.3.2-.1.1-.1.3-.3.2-.3 0-.1-.2-.3-.3l-.2-.2c-.1.2-.2.37 0 .5.2.1.4.2.4.35-.1.1-.2.2-.2.3-.1.2-.1.5-.1.6l-.2.2-.1.4v.1l-.3.1.1.2c-.1.1-.1.1-.2.1s-.2.1-.2.2.2 0 .3 0c.4 0 .7.3.6.5 0 .1-.2.2-.3.2-.2.1-.6.2-.8.3-.3.2-.1.37 0 .57v.4l.3.2c.1.1.3-.1.4-.1.17-.1.2 0 .38 0 .1 0 .2-.1.2-.2.2-.1.5-.1.7-.5.06 0 .1-.1.1-.2s-.1-.1 0-.3c0-.1.2-.3.26-.5.1-.1-.1-.2 0-.3.1-.1.3-.1.4-.3.2-.1.2-.4.3-.5.2-.1.3 0 .6-.1l.87-.3.1-.05c.3 0 .1.3 0 .4-.1.1-.1.1-.2.1h.1c.1 0 .4-.1.4-.3 0-.1 0-.1-.1-.2.1-.1.1-.1.1-.3 0 0-.1-.1-.1-.2s.1-.1.2-.2c-.2 0-.2.1-.4.1-.1.1-.1 0-.2.1-.1 0-.1.1-.2.1-.1.07-.2 0-.3.08-.1 0-.3.1-.4-.1 0-.1 0-.1.06-.2l.1.1c.2-.25.2-.1.4-.2.27-.1.4-.3.68-.4.2 0 .2.1.4.1.2.07.4-.1.6-.2v.1c0 .1.1.1.1.1.3 0 .4-.4.1-.33l.3-.4c-.2 0-.2.1-.6.1l.2-.2v-.1l.3-.4c0 .3.1.2.3.3.1-.1.3-.1.4-.2.06-.1.26-.3.3-.4v-.25l.2-.3c.08-.1.1-.3.1-.4 0-.1 0-.2.1-.2s.3.2.36.3c.03 0 .12.1.2.2.13.3-.1.5-.2.8-.1.2-.1.4-.2.6-.1.2-.5.7-.7.9l-.4.4c-.08.2-.1.3-.1.5 0 .1.13.2.1.3-.1.1-.5.5-.6.5-.28.1-.2 0-.5.2-.26.2-.5.4-.8.5 0-.1.03-.2 0-.3 0-.06 0-.1-.1-.1 0 0 0-.1-.1-.1s-.2.1-.3.16c-.1.1-.1.13-.3.3l-.8.6c-.4.3-.6.7-.8.8-.1.1-.4.2-.5.26-.1 0-.2 0-.3.1-.1.1 0 .2-.14.4-.1.1-.3.3-.4.5-.1.2.1.2-.1.4 0 .1-.4.26-.5.35-.2.2-.3.4-.5.6l-.2.2c-.1.1-.3.2-.2.3 0 .1.1.1.1.2 0 0 .1.1.1.2 0 .2-.2.53 0 .8.1.1.2.1.5.1.4.1.78.3 1.1.34.5 0 1.1 0 1.6-.1l.7-.4c.4-.2.76-.3 1.17-.6l.8-.7c.2-.16.4-.4.7-.4.3-.1.4.03.7-.2l.45-.4c.1-.1.1-.2.3-.2.4 0 .06.6.4.7.2 0 .6-.2.86-.3.1-.1.6-.1.74-.05 0 0 .1.1.2.1.1.06.2 0 .3.1 0 .06-.1.3-.1.35-.1.2-.1.7.1.8h.4l.8-.2c.35-.1.5.1.8.1.16 0 .4-.1.5-.2l.8-.2c.3-.1.3.1.5 0 .5-.2.9-.9 1.1-1.3l.46-.73c.2-.3.4-.6.5-.9.3-.6.4-1.3.3-2 0-.2 0-.7-.05-.8 0-.1-.2-.1-.2-.3-.1-.2.1-.6 0-.9 0-.1-.1-.3-.3-.3-.1.1-.1.2-.3.2-.1-.5 0-1 0-1.5 0-.2 0-.6-.1-.8-.1-.2-.3-.1-.4-.1s-.1-.1-.2-.05c-.1 0-.2.2-.3.2H86c-.1 0-.17.1-.2.2-.3-.2-.46-.9-.5-1.3-.2-.8-.3-1.6-.9-2.3l-.47-.5c-.1 0-.2-.1-.3 0-.14.16 0 .6 0 .8v.78c0 .2.04.37 0 .5-.05.17-.1.3-.2.4-.1-.04-.2 0-.26.1l-.3.5c-.04.1-.13.36-.24.4-.1.08-.2.06-.3.18-.1.05-.2.2-.3.24h-.3c-.1.1-.2.2-.2.3l-1 .4c0-.05.1-.1 0-.1-.04-.15-.34-.24-.16-.4l.1-.1.35-.3.2-.2c.1 0 .2 0 .3-.1l.5-.5c.2-.1.5.1.6-.3.1-.2 0-.8 0-1.1l-.1-.6-.1-.4c-.1-.3-.1-.5-.3-.8l-.3-.4c-.1-.13-.2-.3-.3 0-.1.3 0 .5-.3.6.1.3.4.7.2 1-.1.17-.2.2-.3.3-.07.1-.1.2-.17.2-.1 0-.16 0-.2-.02 0-.1.1-.24.1-.3.2-.2.3-.3.3-.6.05-.2 0-.37 0-.5 0-.2.1-.2.1-.37v-.6l-.26-1c0-.38.2-.56.1-.9l.1.1c.2-.3.1-.5-.1-.7.1-.1.4-.3.5-.38l.3-.6c.1-.1.2-.45.2-.6 0-.1-.3-.35-.4-.4H81c-.13.03-.3.2-.46.1-.2-.1-.6-.5-.8-.6-.5-.4-.43-.3-.65-.4-.2-.1-.2-.2-.3-.3-.1-.1-.2-.1-.2-.2-.1 0-.1-.1 0-.3-.1-.2-.1-.3-.1-.5.1-.1.2-.1.2-.2 0-.3-.4-.25-.5-.5 0-.17.1-.46.2-.5l.2-.2c0-.1-.1-.27-.1-.4-.1-.3.1-.37-.1-.74-.1-.2-.2-.3-.3-.4-.2-.1-.3.1-.3.2 0 .15.1.3.2.44.1.1.2.3.2.5s-.3.2-.4.2l-.1-.2c-.1-.2-.2-.2-.3-.5 0-.1-.1-.46-.2-.5 0-.07-.4-.17-.5-.2-.2-.06-.6-.2-.6.03-.2.2.1.5.1.7 0 .07.1.24 0 .3 0 .04-.2 0-.2 0-.2-.1-.4-.1-.5-.3.1-.03.3-.1.3-.2-.1-.1-.3-.2-.4-.1-.1.04-.1.14-.3.14-.2-.04-.6-.3-.8-.33-.3-.1-.6-.1-.8-.1-.2 0-.7.1-.7.3v.2c-.2.1-.1.3-.1.5 0 .1.1.1 0 .2s-.2.04-.2.04h-.4l.3.2c.2.1.3 0 .4.3-.2.1-.5.1-.7 0l.2-.2v-.1c-.1 0-.5 0-.5-.1-.1 0 0-.1 0-.2-.1 0-.2 0-.2-.2 0-.1.1-.2 0-.3h-.2c-.2 0-.4-.1-.5.1-.1.1.1.2.2.5l-.4.1c-.1 0-.2.2-.3.2-.2 0-.4-.1-.5 0-.3 0-.5.2-.8.4-.1.1-.3.2-.3.3-.1.1-.1.2-.1.3 0 .14-.2.3-.1.5.1.1.3.06.4.1l.3.2c-.1.1-.2.1-.4.2l-.5.4c-.3.2-.5.1-.7.1-.1 0-.2.1-.3.1l-.2-.1c-.1-.1-.4.1-.4.1.03.1.1.1.03.1 0 .1-.1.3-.2.4 0 .06-.1.1-.1.1l-.1-.1c-.1-.14-.1-.1-.2 0s-.1.27-.2.4v-.33c0-.1.1-.2.2-.36l.2-.4c0-.1.1-.2.13-.3.1-.2-.16-.8-.37-1-.3.4-.2.3-.3.6-.1.1-.1.2-.2.2-.1.1-.1.2 0 .3zm1.9-2.4h.4l.4.2c.1-.2.1-.2.2-.3 0-.1.3-.2.2-.3l-.1-.1v.1c-.2-.1-.3-.1-.4 0-.1 0-.5.2-.6.3zm.9-.4c.3-.3.2-.3.4-.4.1-.1.3-.2.4-.2v.1c.2-.1.1-.2.3-.2.2-.1.4.1.7 0 .1 0 .2 0 .2-.2.1 0 .1 0 .2-.1-.1-.1-.1-.2-.1-.2-.1-.1-.4 0-.3.2-.2 0-.2-.1-.2-.1-.2-.1-.4 0-.5.1-.2-.2-.1-.2-.5-.1-.1 0-.4 0-.5.1-.2 0-.2.2-.2.3 0 .1-.1.1-.2.2s0 .2.1.3zm4.3-4l.5.1c.2.1.4.1.7.2.1 0 .3 0 .4-.1 0-.1.1-.6-.2-.6-.1 0-.2.1-.2.1l-.3-.4c-.1 0-.1-.1-.2 0s.3.4 0 .4H74c-.1.1.1.1.2.2.15 0 .3 0 .37.1-.3 0-.4-.2-.7-.3-.2 0-.3-.1-.44 0zm.9-.8c.2.1.6.3.9.3-.2-.2-.6-.4-.8-.3zM58.1 212l.2-.2.7-.2c.18-.04.36-.15.57-.05-.3.2-.3.1-.58.2-.3.1-.3.2-.5.3l-.2.06-.6.5c-.2.1-.3 0-.4 0-.2 0-.3.1-.3.2l-.3.6c-.2.4-.4.8-.4 1.2-.1.3 0 .4 0 .7-.1.3-.3.7-.3 1.1-.1.4 0 .5 0 .6 0 .1-.2.4-.3.5-.1.1-.1.2-.2.2v.3l-.1.4c0 .2-.1.7 0 .8.1.2.4.1.4.4v.1c-.1.2-.3.1-.4.1-.2.1-.3.4-.5.3-.2 0-.2-.2-.3-.2l-.3-.1c-.1-.1-.2-.3-.5-.5-.2-.1-.3-.1-.2.2v.2c-.2-.1-.2-.3-.5-.2-.2.1-.1.4-.1.6-.1.6-.1.6-.3.9l-.1.5-.1.3v.6l.3 1.1c0 .3.1.6 0 .8-.1.1-.3.2-.4.2h-.3c-.1.1-.3.2-.5.2s-.4-.1-.5-.1c-.1.1-.3.1-.3.2-.2.1-.3.2-.4.2-.3.1-.7-.2-.9-.3-.1 0-.3-.2-.4-.1-.1 0-.2.2-.3.2-.1.1-.4 0-.6 0 0 0-.1 0-.2.1 0 0 0 .2.1.2.1.2.2.2.3.3 0 0 .2.1.1.2-.1.2-.4-.1-.4.2v.1H48l-.4-.3-.1-.1-.4-.3-.1.3-.2-.2-.2-.1c-.1-.1-.2 0-.2.1-.1.3-.1.5-.1.7-.1.2-.2.2-.3.3-.1.1-.1.3 0 .5l.4 1.1c.3.9.3 1.1.84 1.8l.3.4.5.6.2.3h.1c-.24-.3-.56-.9-.65-1.2-.1-.4 0-.5-.2-.9l.2.3c0-.2 0-.3.1-.5.1.1.1 0 .3.2.1.1.1.2.3.2.1.1.1.1.3.1l.2.2c.1.1.3.4.5.3 0-.2-.2-.4-.3-.6 0 0-.1-.2 0-.2 0-.1.2.1.3.1.1.2.3.4.5.5.2.1.3 0 .6.25l-.1-.1c.1.1.1.3.4.3-.1-.1-.4-.5-.4-.6 0-.1.1-.1.1-.2l.6.8c.1 0 .2.2.3.2.2 0 .3-.2.4-.1l.4.4.8.7c.2.13.5.4.8.4.1.03.2.1.3 0 .1-.1 0-.2 0-.3v-.3c-.1-.1-.2-.2-.2-.4 0 .2.1.2.2.3.1.2.3.4.5.5.2.2.5.4.8.6.2.1.5.16.8.2.3.1.6.2 1 .2l.4.1h.4c.3 0 .2-.24.3-.35.1 0 .4 0 .5.1.6.1.4.1.9.3l1 .3c.2 0 .6.2.8.1l.2-.1c.2-.1.6-.2.8-.4.1-.1.1-.18.1-.2 0-.1 0-.3.1-.3.1-.08.4-.1.5-.1.3-.08.8-.1 1.1-.2.3-.1.4-.4.2-.6-.18-.1-.5-.1-.9-.3-.3-.2-.5-.4-.8-.5l-.68-.25-.4-.2-.2-.1c-.1 0-.2-.12-.3-.2l-.67-.5c-.3-.2-.5 0-.8-.2.2.1.5.1.7.1-.2-.1-.5-.3-.7-.4l-.4-.1c.2.1.3.1.5 0l-.1-.2c-.05-.3 0-.37-.1-.6-.3-.37-1-.7-1.37-1.2-.18-.2-.27-.4-.37-.67l-.2-.4c0-.1 0-.2-.1-.3l-.1-.26-.2-.36-.4-.3-.2-.3-.3-.3c-.2-.3-.1-.5-.2-.7-.04-.1-.3-.3-.4-.3-.1 0-.24.1-.3 0 0-.2.3-.1.4-.1-.1-.3-.1-.3-.3-.5l-.45-.57c-.1-.1-.3-.1-.3-.2 0-.04.1-.1.1-.24.08-.2 0-.3-.03-.4l-.2-.4c-.1-.2-.1-.6.1-.8.2-.2.5-.1.6-.1.1-.1.1-.3.1-.4l-.2-1h.1c.24.1.4.1.64.1l.2.1.1-.1c.1-.2-.1-.6-.2-.7-.1-.1-.2-.1-.3-.2v-.2c-.06-.2-.1-.4-.1-.5.1-.4.5-.6.9-.6.2 0 .3.1.3.2.2 0 .3-.1.4 0 0 .1.1.2.1.28.1.2.2.2.2.4.1.2 0 .4 0 .6.1.24.2.2.3.36.1.2 0 .4.1.6 0 .1.1.2 0 .4-.04.1-.2.17-.3.25-.1.1-.2.25-.2.4 0 .04.1.1.1.1.1.13.2.03.3-.07.1-.1.3-.4.6-.4.2.04.5.5.8.54.14.04.2 0 .4-.1.1-.1.2-.1.3 0 .2 0 .3.2.4.2.1 0 .2-.1.3 0l.7.3.1-.4c.1.1.2 0 .1-.1 0-.1-.1-.2-.2-.25.3 0 .34.1.5.4 0 0 .02.1.1.1.1.1.3.2.4.2.13-.1.2-.1.23-.2 0-.2-.1-.5 0-.7 0-.2.2-.4.24-.7-.1 0-.3 0-.3-.1-.03-.1.1-.2.16-.35.07-.2.07-.5 0-.6l-.3.1-.2.2-.4.1c0-.2 0-.3.1-.4l.2-.1c.1-.1 0-.2.1-.3.1-.22.2-.4.1-.6.3-.1.3-.12.4-.2.3 0 .5.3.7.4-.3.1-.1.3 0 .47.1-.1.1-.3.2-.4l.3-.2.2-.2s.3-.1.5 0c.1-.1.1-.1-.1-.2l.1-.1-.14-.1c-.1.1-.2.1-.14.2-.1 0-.1 0-.3.1v-.2c-.26 0-.06-.2-.1-.4 0-.1-.1-.1-.1-.1l.2-.3c0-.2.2-.2.1-.4.27-.1 0-.3.16-.5 0-.1.1-.1.1-.1l.14-.2.2-.2c0-.1 0-.3.1-.4v-.2c0-.1-.1-.2-.2-.3.1-.1.2-.1.2-.2s0-.2-.1-.2h-.1l.1-.5-.1-.4v.1-.2l-.3.2v-.4c.1-.1.2-.2.2-.4-.2.2-.4.6-.4.9l-.1.4v-.1c-.2.2-.1.3-.1.4.1 0-.4.3-.3.22-.13.1-.32.07-.5 0-.1 0-.2 0-.23.1l-.6-.1v-.1H62c-.3 0-.4-.2-.5-.4-.1-.13-.2-.12-.3-.3-.1 0-.1-.1-.2-.1s-.3 0-.4-.1-.4 0-.5 0c-.2.1-.3.3-.5.3-.2.1-.4 0-.6 0-.1.1-.2.2-.3.2-.1 0-.1-.1-.2-.1s-.2.2-.3.3H58c-.1 0-.4.2-.4.3 0 .03 0 .1.1.12zm15.2-12.5c.4.1.9.23 1.2.1-.1-.06-.2-.04-.4-.06-.2 0-.6-.1-.8 0zm-2.4.2l-.1-.1c.1 0 .2-.03.3.03.1 0 .1.1.2.12.1.2.5.3.66.3.1 0 .1-.04.1-.06l-.4-.4h-.3l-.8-.3c-.05 0-.24-.1-.27-.2 0-.1.1-.2.1-.2l-.8-.2c-.1 0-.2-.1-.3 0-.1.1-.1.2 0 .3 0 .1-.1.2 0 .3l.3.2.6.1c.1 0 .2.1.4 0zm6-3.7c-.2-.3-.7-.5-1.1-.6l-.6-.1c-.3-.1-.6-.27-1-.34s-.6 0-.94 0l-.6-.1-1-.2c-.3 0-.66-.1-.9-.2s-.27-.2-.4-.2c-.1 0-.3 0-.4.1l-.07-.1c0-.25-.1-.1-.4-.2l-.4-.2c-.2-.1-.5-.1-.7-.1l-1.2.04c-.4 0-.9.05-1.2.2-.2.15-.3.4-.5.56-.2.2-.6.4-.7.7 0 .3.5.4.8.4l.6.13c.2 0 .3.1.5.1s.4 0 .6.1c.2 0 0 .1.2.2.2 0 .5.1.6.2.1 0 .2.2.3.2.1 0 .2-.1.3-.2.1-.1.4-.5.5-.5.2 0 .7.2.9.2.1 0 .3.1.3.2.1.1-.3.2-.2.3h.5l.4.1h.5c.1 0 .3.1.4.1.2 0 .2-.3.3-.3.4 0 .7.2 1.1.2.3 0 .3-.1.5-.1h.5c.3 0 .3-.1.6 0 .5 0 .9.1 1.3.2.1.1.5.2.7.1h.1l.1-.3c-.1-.1-.1-.1-.1-.2-.1-.1-.1-.1-.1-.2s-.1-.2-.1-.3c0-.1.2-.1.3-.1zm-9.34-2.6c-.05-.1-.1-.1-.2-.2-.2-.1-.45-.14-.7-.1-.1.05-.37.1-.36.2 0 .16.36.17.45.17h.37c.2 0 .28-.03.48-.1zM57.43 197c.4-.17.5-.25.8-.3.4-.1.6-.02.9-.2l-.5-.16.1-.25h-.5c-.1 0-.2.1-.25.1l-.4.4c-.1.1-.3.3-.2.5zm1.1-1.5c.04.14-.04.24-.1.38l.1.02c.1 0 .5-.16.6-.22.25-.1.2-.23.4-.43l.3-.27c.3-.3.76-.6.97-.9-.2-.1-.2-.06-.4 0-.3.1-.6.24-.8.5-.2.2-.1.3-.4.53l-.5.4zm19.1 43c-6.15 2.1 1.26-.42 0 0z" class="c"/></g><style>.a{clip-rule:evenodd;fill-rule:evenodd;}.b{clip-rule:evenodd;fill-rule:evenodd;fill:#FFF;}.c{fill:#5b92e5;}.d{fill-rule:evenodd;fill:#5b92e5;}</style>';
        }
        setSVGs();
        setTimeout(function(){
            var sbox = d.getElementById("searchbox");
            var search = d.getElementById("search");
            var fitem = d.getElementById("fitem");
            var prepped = "";
            function fixheight(){
                var sboxh = sbox.getBoundingClientRect().top;
                sboxh = w.innerHeight - (sboxh + 10);
                sbox.style.height = (sboxh) + "px";
            }
            $scope.searchready = function(){
                search.className = "";
                fitem.innerHTML = plain;
            }
            $scope.search = function(sval, query){
                switch(sval){
                    case "country":
                        fitem.innerHTML = country;
                        break;
                    case "topic":
                        fitem.innerHTML = solutions;
                        break;
                    case "committee":
                        fitem.innerHTML = un;
                        break;
                    case "unstance":
                        fitem.innerHTML = un;
                        break;
                }
                search.className = "results";
                var sres;
                fixheight();
                if(sval === "country"){
                    sres = d.getElementById("s-country");
                    sres.innerHTML = "<p class='sloading'>Loading...</p>";
                    query = encodeURI(query);
                    setTimeout(function(){
                        $http.get("search.php?q=" + query).then(function(data){
                            data = data.data;
                            sres.innerHTML = "";
                            for(source in data){
                                prepped = "<p class='source'>";
                                prepped += source;
                                prepped += "</p>";
                                sres.innerHTML += prepped;
                                for(item in data[source]){
                                    prepped = "<a class='slink' target='_blank' href='";
                                    prepped += data[source][item][1];
                                    prepped += "'><li class='sitem'>";
                                    prepped += data[source][item][0];
                                    prepped += "</li></a>";
                                    sres.innerHTML += prepped;
                                    prepped = "";
                                }
                            }
                        });
                    },1100);
                } else {
                    sres = d.getElementsByClassName("s-tile");
                    var sreslen = sres.length;
                    for(var i=0;i<sreslen;i++){
                        sres[i].href = sres[i].getAttribute("url-pre");
                        if(sres[i].getAttribute("noplus")===null)
                            sres[i].href += $scope.query.replace(/ /g, "+");
                        else
                            sres[i].href += $scope.query;
                    }
                }
                sbox.style.transition = ".1s";
            }
            $scope.switchT = function(change){
                if($scope.sval === ""){
                    if(change)
                        document.getElementById("cradio").click();
                    else
                        d.getElementById("sradio").click();
                    return;
                }
                var tMap = {
                    1: "cradio",
                    2: "tradio",
                    3: "comradio",
                    4: "sradio"
                }
                var nMap = {
                    "country": 1,
                    "topic": 2,
                    "committee": 3,
                    "unstance": 4
                }
                var newVal = nMap[sval]+change;
                if(newVal === 0)
                    newVal = 4;
                else if(newVal === 5)
                    newVal = 1;
                document.getElementById(tMap[newVal]).click();
            }
        },0);
    }
});

function noteMake(){
    d.getElementById("dragndrop").style.display = "table";
}
function hideNoteMake(){
    d.getElementById("dragndrop").style.display = "none";
}
setTimeout(function(){
    //        d.getElementsByClassName("sideitem")[1].click();
    var dropz = d.getElementById('dropzone');
    if(dropz){
        var dropzone = new Dropzone("div#dropzone", { url: "submit.php"});
        dropzone.options.dropzone = {
            maxFilesize: 8,
            maxFiles: 1,
            acceptedFiles: "image/*,.pdf,.docx"
        }
        dropzone.on("addedfile",function(file){
            if(file.size > 8388608){
                alert("File exceeds 8MB limit.");
                dropzone.removeAllFiles(true);
                dropzone.removeAllFiles();
            } else if(file.type !== "application/pdf" && file.type !== "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && file.type.indexOf("image/") === -1){
                dropzone.removeAllFiles(true);
                dropzone.removeAllFiles();
                alert("Accepted file types are PDFs, Word Documents and images only.");
            }
        });
        dropzone.on("sending", function(file, xhr, formData) {
            formData.append("notename", "");
            formData.append("foldernum", folderid);
            bloc = angular.element(d.getElementById("container")).scope().bloc;
            formData.append("bloc", bloc);
        });
        dropzone.on("success",function(file){
            hideNoteMake();
            angular.element(d.getElementById("container")).scope().refresh();
        });
    }
},0);