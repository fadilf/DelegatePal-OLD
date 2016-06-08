<?php session_start();
include_once("app-functions.php");
if(!loggedin()){
    header("Location: ../");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <title>DelegatePal Workspace</title>
        <?=minCSS()?>
    </head>
    <body ontouchstart="document.body.className='touch'">
        <?php include_once("../analyticstracking.php") ?>
        <div id="container" ng-app="DelegatePal" ng-controller="control">
            <input type="checkbox" id="menub" ng-init="menuVisible=false" ng-model="menuVisible" />
            <div id="masthead">
                <a href="../app/">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 214 36.83" id="brand">
                        <switch>
                            <foreignObject width="1" height="1" x="0" y="0" requiredExtensions="http://ns.adobe.com/AdobeIllustrator/10.0/"/>
                            <g>
                                <path d="M145 15.4h-7.19c.12-.79.36-1.45.73-2 .37-.54.83-.95 1.38-1.23s1.16-.42 1.83-.42c.79.01 1.42.14 1.9.39.49.25.84.6 1.06 1.03.22.44.33.94.33 1.5 0 .12 0 .25-.01.36v.4m4 7.7c-.14-.25-.3-.44-.47-.54-.16-.11-.37-.16-.6-.16-.1 0-.23.01-.4.03-.17.03-.33.06-.48.12-.77.36-1.54.64-2.33.85s-1.62.32-2.5.33c-.91-.01-1.7-.16-2.36-.47-.65-.31-1.17-.74-1.56-1.3s-.63-1.22-.73-1.99c-.02-.15-.02-.34-.03-.56s-.01-.41-.01-.58h10.6c.25 0 .48-.04.7-.13s.38-.2.48-.35c.13-.19.22-.4.27-.65.05-.24.07-.47.07-.68.01-1.16-.09-2.28-.31-3.33-.22-1.06-.61-2-1.17-2.83s-1.36-1.48-2.39-1.97c-1.03-.48-2.36-.72-3.99-.73-1.24 0-2.4.21-3.51.63-1.1.42-2.08 1.05-2.94 1.89-.85.84-1.53 1.89-2.02 3.17-.49 1.27-.74 2.76-.75 4.46.01 1.41.2 2.69.58 3.86.38 1.16.94 2.17 1.67 3.01s1.62 1.5 2.68 1.96c1.05.46 2.26.7 3.6.7.97 0 1.88-.08 2.74-.24.85-.15 1.69-.38 2.48-.68s1.57-.66 2.34-1.08c.27-.13.47-.31.62-.53s.23-.47.23-.76c.01-.18-.02-.4-.08-.65 0-.3 0-.5-1-.8zm-18 1c-.08-.34-.23-.56-.46-.67-.23-.1-.48-.15-.76-.14-.19.01-.44.02-.76.06-.31.03-.64.05-.98.06-.43 0-.8-.06-1.12-.19-.31-.12-.56-.31-.73-.55-.14-.18-.24-.4-.32-.66s-.14-.58-.17-.96c-.04-.39-.05-.85-.05-1.4v-7h3.36c.46-.01.81-.13 1.03-.37.23-.25.34-.6.34-1.06v-.96c0-.48-.11-.84-.34-1.08-.22-.24-.56-.36-1.03-.36h-3.36V5.44c0-.49-.12-.85-.36-1.08-.23-.22-.58-.33-1.04-.33-.08 0-.23.01-.46.01-.23.01-.47.02-.75.04-.27.02-.52.04-.75.06-.28.04-.52.14-.71.3s-.34.36-.44.58c-.1.23-.16.48-.17.74-.04.66-.07 1.2-.09 1.62s-.04.74-.05.97v.52c-.26 0-.61.01-1.02.03-.42.03-.85.06-1.3.12-.39.03-.69.17-.91.41s-.33.59-.34 1.07v.78c0 .46.12.82.35 1.06.23.25.57.37 1.01.38h2.18v8.49c0 .78.04 1.46.1 2.04.07.58.19 1.09.35 1.52s.36.82.62 1.16c.26.36.6.67 1.01.92.42.25.88.44 1.4.58.52.13 1.06.2 1.65.2.79 0 1.52-.03 2.19-.1.68-.07 1.32-.18 1.94-.34.2-.05.39-.13.56-.24s.31-.25.42-.42c.1-.16.16-.35.17-.56 0-.28-.01-.58-.04-.89 1-.3 1-.6 1-.9zm-21-1.4c-.32.27-.68.52-1.09.73-.4.22-.82.39-1.27.52-.44.12-.89.19-1.33.19-.51 0-.95-.08-1.34-.25-.39-.16-.69-.42-.91-.76-.21-.35-.33-.8-.33-1.35 0-.48.12-.88.38-1.2.25-.32.64-.58 1.18-.79.45-.16.95-.28 1.51-.37.55-.09 1.11-.17 1.67-.21s1.08-.07 1.54-.08v3.6zm4 .9v-8.41c0-.88-.03-1.64-.1-2.28s-.17-1.19-.31-1.64c-.13-.45-.31-.85-.52-1.17-.41-.66-1.03-1.16-1.86-1.48s-1.86-.48-3.08-.48c-.45 0-.98.02-1.59.08-.6.05-1.24.14-1.92.24s-1.36.23-2.05.38-1.36.32-2 .52c-.36.11-.63.26-.84.47-.2.21-.3.5-.31.86 0 .26.02.52.07.79.04.27.12.52.23.76.11.22.23.39.38.52.14.12.33.18.54.18.07 0 .17-.01.3-.02.14-.02.27-.03.41-.05s.25-.03.33-.04c.65-.13 1.29-.25 1.92-.34s1.21-.17 1.75-.21c.54-.05.99-.07 1.35-.07.64-.01 1.13.06 1.47.18s.59.32.74.6c.15.21.25.52.3.92.06.41.08.86.07 1.37v.7c-1.44.02-2.82.11-4.13.28-1.3.17-2.49.42-3.55.75-.71.22-1.33.56-1.86 1.01-.53.46-.95 1.01-1.25 1.67s-.45 1.41-.46 2.26c0 .75.12 1.46.36 2.15.25.69.61 1.3 1.11 1.85s1.12.98 1.88 1.3 1.65.49 2.67.49c.62 0 1.25-.09 1.89-.25.65-.17 1.27-.42 1.9-.77.62-.35 1.2-.79 1.75-1.33l.07.92c.05.47.2.8.47.98.26.19.59.28.97.27.56 0 1.14-.03 1.73-.09.59-.05 1.16-.12 1.72-.21s1.07-.17 1.53-.26c.35-.07.62-.24.8-.49s.27-.58.27-.98v-.48c0-.48-.12-.84-.35-1.08s-.57-.36-1.01-.36h-3zm-23.7-8.6c0 1.07-.26 1.86-.78 2.39s-1.28.79-2.28.79c-.58 0-1.1-.11-1.54-.34-.45-.23-.8-.57-1.06-1.03-.25-.47-.38-1.05-.39-1.77 0-.58.1-1.11.32-1.6.22-.5.55-.9 1-1.2.45-.31 1.03-.47 1.75-.47.77.01 1.37.16 1.81.46s.74.69.92 1.18c.2.5.3 1 .3 1.6zm-5.5 13.1l3.43.26c.85.07 1.52.2 2.01.39.49.2.82.45 1.02.76s.3.69.29 1.13c.01.41-.13.81-.42 1.18-.28.38-.73.68-1.34.92s-1.42.36-2.41.37c-1.03 0-1.88-.1-2.55-.29-.66-.19-1.16-.45-1.48-.79s-.48-.72-.48-1.17c-.01-.52.14-1.02.45-1.48.4-.5.9-.9 1.5-1.3zm-.3-6.8c.37.11.79.19 1.26.25.46.06.93.09 1.4.09 1.11 0 2.13-.14 3.06-.41.94-.28 1.76-.68 2.46-1.22s1.24-1.22 1.64-2.03c.39-.81.59-1.76.59-2.83.01-.39-.03-.8-.12-1.22-.08-.42-.24-.84-.47-1.25h1.59c.46-.01.82-.13 1.06-.37.25-.25.38-.6.38-1.06v-.77c0-.46-.13-.81-.38-1.04-.24-.24-.6-.36-1.06-.36h-4.21c-.31-.17-.67-.33-1.07-.45-.4-.13-.87-.23-1.4-.29-.53-.07-1.16-.1-1.88-.1-1.4.01-2.61.2-3.62.58s-1.84.9-2.49 1.55-1.12 1.39-1.44 2.21c-.31.82-.46 1.69-.46 2.6 0 .73.1 1.42.3 2.07s.5 1.24.9 1.77c.39.54.88.98 1.46 1.36-.55.59-1 1.12-1.33 1.59-.34.47-.58.92-.73 1.32s-.23.78-.23 1.15c0 .71.19 1.33.59 1.88.39.54 1.01.94 1.85 1.19-.9.41-1.64.84-2.2 1.29-.55.45-.96.94-1.22 1.45s-.39 1.05-.38 1.61c-.01.63.13 1.25.41 1.85s.73 1.14 1.37 1.62c.63.48 1.49.87 2.56 1.15s2.39.43 3.97.44c1.64-.01 3.1-.18 4.37-.53 1.27-.36 2.34-.85 3.22-1.49.87-.64 1.53-1.4 1.99-2.27.45-.87.68-1.82.68-2.86.01-1-.17-1.87-.53-2.61s-.95-1.35-1.75-1.81c-.81-.46-1.88-.77-3.22-.93l-6.12-.7c-.41-.05-.73-.13-.94-.25-.21-.11-.36-.24-.43-.38-.07-.15-.11-.3-.1-.44-.01-.17.04-.37.14-.59 0-.3.1-.5.4-.7zm-12.5-5.9h-7.2c.12-.79.36-1.45.73-2 .37-.54.83-.95 1.38-1.23s1.16-.42 1.83-.42c.79.01 1.42.14 1.9.39.49.25.84.6 1.06 1.03.22.44.33.94.33 1.5 0 .12 0 .25-.01.36v.4zm4.2 7.7c-.14-.25-.3-.44-.47-.54-.17-.11-.37-.16-.6-.16-.1 0-.23.01-.4.03-.17.03-.33.06-.48.12-.77.36-1.54.64-2.33.85s-1.62.32-2.5.33c-.91-.01-1.7-.16-2.36-.47-.65-.31-1.17-.74-1.56-1.3s-.63-1.22-.73-1.99c-.02-.15-.02-.34-.03-.56s-.01-.41-.01-.58h10.6c.25 0 .48-.04.7-.13s.38-.2.48-.35c.13-.19.22-.4.27-.65.05-.24.07-.47.07-.68.01-1.16-.09-2.28-.31-3.33-.22-1.06-.61-2-1.17-2.83s-1.36-1.48-2.39-1.97c-1.03-.48-2.36-.72-3.99-.73-1.24 0-2.4.21-3.51.63s-2.08 1.05-2.94 1.89c-.85.84-1.53 1.89-2.02 3.17-.49 1.27-.74 2.76-.75 4.46.01 1.41.2 2.69.58 3.86.38 1.16.93 2.17 1.67 3.01.73.84 1.62 1.5 2.68 1.96 1.05.46 2.26.7 3.61.7.97 0 1.88-.08 2.74-.24.86-.15 1.69-.38 2.48-.68s1.57-.66 2.34-1.08c.27-.13.47-.31.62-.53s.23-.47.23-.76c.01-.18-.02-.4-.08-.65-.3-.2-.4-.4-.5-.7zm-18 2.7v-.55c0-.44-.12-.77-.34-1.01-.23-.23-.56-.37-.98-.43l-2-.2V1.44c-.01-.46-.13-.8-.37-1.03-.3-.26-.6-.37-.9-.37-.31 0-.69.02-1.14.07-.45.06-.94.12-1.46.21-.53.09-1.06.18-1.59.3-.53.1-1.04.22-1.52.35-.36.09-.66.27-.89.52-.23.26-.36.6-.36 1.03v.55c.01.46.14.82.38 1.06.25.25.59.38 1.02.38h2.07v19.1l-1.88.26c-.42.06-.74.2-.95.43-.2.23-.31.57-.31 1.01v.55c.01.46.13.81.37 1.05.25.24.59.36 1.03.36h8.45c.46 0 .81-.12 1.05-.36.3-.2.4-.5.4-1zm-17.7-10.4h-7.19c.12-.79.36-1.45.73-2 .37-.54.83-.95 1.38-1.23s1.16-.42 1.83-.42c.79.01 1.42.14 1.9.39.49.25.84.6 1.06 1.03.22.44.33.94.33 1.5 0 .12 0 .25-.01.36v.4zm4.1 7.7c-.14-.25-.3-.44-.47-.54-.17-.11-.37-.16-.6-.16-.1 0-.23.01-.4.03-.17.03-.33.06-.48.12-.77.36-1.54.64-2.33.85s-1.62.32-2.5.33c-.91-.01-1.7-.16-2.36-.47-.65-.31-1.17-.74-1.56-1.3s-.63-1.22-.73-1.99c-.02-.15-.02-.34-.03-.56s-.01-.41-.01-.58h10.6c.25 0 .48-.04.7-.13s.38-.2.48-.35c.13-.19.22-.4.27-.65.05-.24.07-.47.07-.68.01-1.16-.09-2.28-.31-3.33-.22-1.06-.61-2-1.17-2.83s-1.36-1.48-2.39-1.97c-1.03-.48-2.36-.72-3.99-.73-1.24 0-2.4.21-3.51.63s-2.08 1.05-2.94 1.89c-.85.84-1.53 1.89-2.02 3.17-.49 1.27-.74 2.76-.75 4.46.01 1.41.2 2.69.58 3.86.38 1.16.94 2.17 1.67 3.01s1.62 1.5 2.68 1.96c1.05.46 2.26.7 3.6.7.97 0 1.88-.08 2.74-.24.85-.15 1.69-.38 2.48-.68s1.57-.66 2.34-1.08c.27-.13.47-.31.62-.53s.23-.47.23-.76c.01-.18-.02-.4-.08-.65-.2-.2-.3-.4-.5-.7zm-35.7-.2V6.63h2.14c1.13-.01 2.19.07 3.17.25s1.85.5 2.59.97c.64.41 1.16.94 1.55 1.59.4.65.69 1.39.87 2.21s.28 1.71.27 2.65c.01 1.38-.12 2.61-.37 3.67-.26 1.07-.68 1.97-1.27 2.69-.58.72-1.36 1.26-2.34 1.61-.45.16-.95.29-1.49.39-.53.1-1.09.17-1.66.21-.57.05-1.13.07-1.69.07H8.93zm-7.42 4.3h6.38c1.26.01 2.49-.01 3.7-.06 1.21-.04 2.36-.15 3.44-.31 1.09-.16 2.09-.42 3.01-.77 1.73-.66 3.12-1.57 4.16-2.71 1.03-1.14 1.78-2.5 2.23-4.08.46-1.58.68-3.36.66-5.34-.01-2.22-.37-4.09-1.07-5.6s-1.69-2.72-2.96-3.62-2.77-1.53-4.49-1.89c-.58-.12-1.28-.23-2.09-.31s-1.7-.14-2.66-.18-1.96-.06-3-.06H1.48c-.44 0-.79.12-1.08.36-.28.32-.42.69-.43 1.17v.52c.01.46.14.81.41 1.06.26.25.62.4 1.07.46l2.32.25v17.5l-2.33.26c-.45.04-.81.18-1.07.42-.26.3-.39.6-.4 1.1v.55c.01.44.15.79.42 1.03.28.3.64.4 1.09.4z"/>
                                <path id="brandblue" fill="#23a0bf" d="M214 25.8v-.55c0-.44-.12-.77-.34-1.01-.23-.23-.56-.37-.98-.43l-1.99-.26V1.45c-.01-.46-.13-.8-.37-1.03-1-.26-1-.37-2-.37-.31 0-.69.02-1.14.07-.45.06-.94.12-1.46.21-.53.09-1.06.18-1.59.3-.53.1-1.04.22-1.52.35-.36.09-.66.27-.89.52s-.36.6-.36 1.03v.55c.01.46.14.82.38 1.06.25.25.59.38 1.02.38h2.07v19.1l-1.88.26c-.42.06-.74.2-.95.43-.2.23-.31.57-.31 1.01v.55c.01.46.13.81.37 1.05.25.24.59.36 1.03.36h8.45c.46 0 .81-.12 1.05-.36 2-.2 2-.5 2-1m-20-3.1c-.32.27-.68.52-1.09.73-.4.22-.82.39-1.27.52-.44.12-.89.19-1.33.19-.51 0-.95-.08-1.34-.25-.39-.16-.69-.42-.91-.76-.22-.35-.33-.8-.33-1.35 0-.48.12-.88.38-1.2.25-.32.64-.58 1.18-.79.45-.16.95-.28 1.51-.37.55-.09 1.11-.17 1.67-.21s1.08-.07 1.54-.08v3.6zm5 .9v-8.41c0-.88-.03-1.64-.1-2.28s-.17-1.19-.31-1.64c-.13-.45-.31-.85-.52-1.17-.41-.66-1.03-1.16-1.86-1.48s-1.86-.48-3.08-.48c-.45 0-.98.02-1.59.08-.6.05-1.24.14-1.92.24s-1.36.23-2.05.38-1.36.32-2 .52c-.36.11-.63.26-.84.47-.2.21-.3.5-.31.86 0 .26.02.52.07.79.04.27.12.52.23.76.11.22.23.39.38.52.14.12.33.18.54.18.07 0 .17-.01.3-.02.14-.02.27-.03.41-.05s.25-.03.33-.04c.65-.13 1.29-.25 1.92-.34s1.21-.17 1.75-.21c.54-.05.99-.07 1.35-.07.64-.01 1.13.06 1.47.18s.59.32.75.6c.15.21.25.52.3.92.06.41.08.86.07 1.37v.7c-1.44.02-2.82.11-4.13.28-1.3.17-2.49.42-3.55.75-.71.22-1.33.56-1.86 1.01-.53.46-.95 1.01-1.25 1.67s-.45 1.41-.46 2.26c0 .75.12 1.46.36 2.15.25.69.62 1.3 1.11 1.85.5.55 1.12.98 1.88 1.3s1.65.49 2.67.49c.62 0 1.25-.09 1.9-.25.65-.17 1.27-.42 1.9-.77.62-.35 1.2-.79 1.75-1.33l.07.92c.05.47.2.8.47.98.27.19.59.28.97.27.56 0 1.14-.03 1.73-.09.59-.05 1.16-.12 1.72-.21s1.07-.17 1.53-.26c.35-.07.62-.24.8-.49s.27-.58.27-.98v-.48c0-.48-.12-.84-.35-1.08s-.57-.36-1.01-.36h-1zm-30-10.2V6.54h2.32c.73 0 1.4.04 2 .14.6.09 1.11.23 1.5.42.5.25.89.6 1.17 1.08s.42 1.04.42 1.69c-.01.83-.18 1.52-.54 2.07s-.85.95-1.49 1.21c-.26.1-.58.18-.94.23-.36.06-.74.1-1.14.14-.4.02-.79.04-1.16.04h-2zm4 12.4v-.55c0-.44-.11-.79-.34-1.03-.22-.24-.56-.37-1.03-.41l-2.99-.26v-6.05h2.1c1.02.01 2.02-.04 3-.14s1.9-.29 2.75-.56c1.66-.58 2.91-1.47 3.74-2.68.83-1.2 1.24-2.7 1.24-4.48 0-1.3-.18-2.4-.56-3.32-.37-.92-.94-1.66-1.7-2.24s-1.72-1.01-2.87-1.3c-.39-.1-.87-.19-1.43-.25-.56-.07-1.16-.12-1.8-.16s-1.27-.07-1.9-.08c-.63-.02-1.21-.02-1.74-.02h-8.23c-.45 0-.81.12-1.09.36s-.42.6-.42 1.08v.52c.01.46.14.81.41 1.06s.62.4 1.07.46l2.32.26v17.8l-2.32.22c-.45.04-.81.18-1.07.42-.26.25-.4.6-.4 1.06v.55c.01.44.15.79.42 1.03.28.24.64.36 1.09.37h10.3c.45 0 .79-.12 1.03-.36v-1z"/>
                            </g>
                        </switch>
                    </svg>
                </a>
                <span id="tagline">•&nbsp;&nbsp;MUN simplified.</span>
                <label id="rightm" for="menub">
                    <span ng-attr-style="background:url({{json.profile.picture}})" id="tinypic"></span>
                    {{json.name}}
                    <i class="fa a-chevron-down"></i>
                </label>
                <div id="dcontainer">
                    <ul id="dropdown">
                        <li id="accountb" ng-click="accountPage()">Profile</li>
                        <li id="logout" ng-click="logOut()">Logout</li>
                    </ul>
                </div>
                <label for="menub" id="secondary"></label>
            </div>
            <ul id="sidebar">
                <li class="sideitem" title="Notebooks" ng-click="title='Notebooks';refresh()">
                    <i class="fa fa-book"></i>
                    <span class="sidetxt">Notebooks</span>
                </li>
                <li class="sideitem" title="Research Tool" ng-click="searchPage()">
                    <i class="fa fa-search"></i>
                    <span class="sidetxt">Research Tool</span>
                </li>
                <li class="sideitem" title="Create Bloc" ng-click="newBloc()">
                    <i class="fa fa-school"></i>
                    <span class="sidetxt">Create Bloc</span>
                </li>
                <li class="sideitem" title="Join Bloc" ng-click="joinBlocModal()">
                    <i class="fa fa-link2"></i>
                    <span class="sidetxt">Join Bloc</span>
                </li>
                <li class="sideitem" title="Mash" ng-click="mashFolder()" ng-if="title=='Notes'">
                    <i class="fa fa-mash"></i>
                    <span class="sidetxt">Mash</span>
                </li>
            </ul>
            <div id="content">
                <br ng-if="title=='Notebooks'" />
                <div id="folders" ng-if="title=='Notebooks'">
                    <div ng-click="openFolder($index)" class="folderitem item" ng-repeat="folder in json.folders" ng-attr-style="background:{{folder.color}}">
                        <span class="text">{{folder.name}}</span>
                        <span class="editrow">
                            <button ng-click="downloadFolder($index)">
                                <i class="fa fa-cloud-download"></i>
                            </button>
                            <button ng-click="editFolderModal($index)">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button ng-click="deleteFolderModal($index)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                    </div>
                    <div ng-click="openBloc($index)" class="folderitem blocitem item mod-{{bloc.moderator}}" ng-repeat="bloc in json.blocs" ng-attr-style="background:{{bloc.color}}">
                        <i class="fa fa-sphere"></i>
                        <span class="text">{{bloc.name}}</span>
                        <span class="editrow">
                            <button ng-click="downloadBloc($index)">
                                <i class="fa fa-cloud-download"></i>
                            </button>
                            <button ng-click="showRefCode($index)">
                                <i class="fa fa-share-alt"></i>
                            </button>
                            <span ng-if="bloc.moderator" class="secondaryedit">
                                <button ng-click="editBlocModal($index)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button ng-click="deleteBlocModal($index)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </span>
                            <span ng-if="!bloc.moderator" class="secondaryedit">
                                <button ng-click="leaveBlocModal($index)">
                                    <i class="fa fa-exit"></i>
                                </button>
                            </span>
                        </span>
                    </div>
                    <div ng-click="newFolder()" class="folderplus plusitem" title="Create a new folder">
                        <span class="text">
                            <i class="plus">+</i>
                        </span>
                    </div>
                </div>
                <div id="notes" ng-if="title=='Notes'" ondragover="noteMake()">
                    <div id="foldername">
                        <a class="back" ng-click="open('Notebooks')">
                            <i class="fa fa-chevron-left"></i>
                            &nbsp;Back
                        </a>
                        <span id="nametxt" ng-if="!bloc">{{json.folders[folderindex].name}}</span>
                        <span id="nametxt" ng-if="bloc">{{json.blocs[folderindex].name}}</span>
                    </div>
                    <br id="newline" />
                    <div ng-click="openNote($index)" class="noteitem item type-{{note.type}}" ng-repeat="note in json.folders[folderindex].notes" ng-attr-title="{{note.name}}" ng-if="!bloc">
                        <div class="preview">
                            <img ng-if="note.type=='image'" ng-src="{{note.preview}}" />
                            <img class="doc" ng-if="note.type=='pdf'||note.type=='word'" ng-src="img/{{note.type}}-thumb.svg" />
                            <div ng-if="note.type=='text'||note.type=='url'" class="previewtext">
                                <span class="floatelement"></span>
                                {{note.preview}}
                                <span ng-if="note.preview.length==0">Empty Note</span>
                            </div>
                            <div ng-if="note.type=='audio'" class="audiopreview">
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>
                        </div>
                        <span class="text">{{note.name}}</span>
                        <span class="editrow">
                            <button ng-click="editNoteModal($index)" alt="ABC">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button ng-click="deleteNoteModal($index)" alt="ABC">
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                    </div>
                    <div ng-click="openNote($index)" class="noteitem item type-{{note.type}}" ng-repeat="note in json.blocs[folderindex].notes" ng-attr-title="{{note.name}}" ng-if="bloc">
                        <div class="preview">
                            <img ng-if="note.type=='image'" ng-src="{{note.preview}}" />
                            <img class="doc" ng-if="note.type=='pdf'||note.type=='word'" ng-src="img/{{note.type}}-thumb.svg" />
                            <div ng-if="note.type=='text'||note.type=='url'" class="previewtext">
                                <span class="floatelement"></span>
                                {{note.preview}}
                                <span ng-if="note.preview.length==0">Empty Note</span>
                            </div>
                            <div ng-if="note.type=='audio'" class="audiopreview">
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>
                        </div>
                        <span class="text">{{note.name}}</span>
                        <span class="editrow">
                            <button ng-click="editNoteModal($index)" alt="ABC">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button ng-click="deleteNoteModal($index)" alt="ABC">
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                    </div>
                    <div ng-click="newNote()" class="plusitem" title="Create a new note">
                        <i>+</i>
                    </div>
                </div>
                <div id="note" ng-if="title=='Note'">
                    <a class="back" ng-click="closeNote()">
                        <i class="fa fa-chevron-left"></i>
                        &nbsp;Save &amp; Close
                    </a>
                    <br id="newline" />
                    <input type="text" ng-model="noteinfo.name" />
                    <div id="txtnote" ng-if="noteinfo.type=='text'">
                        <input type="checkbox" id="editb" />
                        <label for="editb" id="editlabel">Styling<i class="fa fa-chevron-down"></i></label>
                        <text-angular ng-model="noteinfo.data"></text-angular>
                    </div>
                    <div id="imgnote" ng-if="noteinfo.type=='image'">
                        <img ng-src="render.php?id={{noteinfo.id}}" />
                    </div>
                    <div id="pdfnote" ng-if="noteinfo.type=='pdf'">
                        <iframe id="pdfpreview">Loading</iframe>
                    </div>
                    <div id="wordnote" ng-if="noteinfo.type=='word'">
                        <iframe id="pdfpreview">Loading</iframe>
                    </div>
                    <div id="urlnote" ng-if="noteinfo.type=='url'">
                        <input type="checkbox" id="urledit" />
                        <label for="urledit" id="urlb" ng-click="prefix()">
                            <i class="fa fa-pencil"></i>
                        </label>
                        <input id="urlnoteedit" type="text" ng-model="noteinfo.data" />
                        <a id="urlnotedata" ng-href="{{urlprefix}}{{noteinfo.data}}" target="_blank" ng-bind="noteinfo.data"></a>
                    </div>
                </div>
                <div id="account" ng-if="title=='Account'">
                    <a class="back" ng-click="$parent.title='Notebooks'">
                        <i class="fa fa-chevron-left"></i>
                        &nbsp;Back
                    </a>
                    <h3 class="accountheading firsthead">Profile</h3>
                    <span ng-attr-style="background:url({{json.profile.picture}})" id="accountpic">
                        <span id="innerbutton" ng-click="newpicModal()">
                            <span id="innerinnerbuttton">Replace</span>
                        </span>
                    </span>
                    <form ng-submit="userDetails(userName, userUsername, userEducation, userMuns, userAwardswon)">
                        <div class="accountrow">
                            <span class="label">Name:</span>
                            <input type="text" ng-model="$parent.userName" />
                        </div>
                        <div class="accountrow">
                            <span class="label">Username:</span>
                            <input type="text" ng-model="$parent.userUsername" />
                        </div>
                        <div class="accountrow">
                            <span class="label">Education:</span>
                            <textarea type="text" class="multiline" ng-model="$parent.userEducation"></textarea>
                        </div>
                        <div class="accountrow">
                            <span class="label">MUNs Attended:</span>
                            <textarea type="text" class="multiline" ng-model="$parent.userMuns"></textarea>
                        </div>
                        <div class="accountrow">
                            <span class="label">Awards Won:</span>
                            <textarea type="text" class="multiline" ng-model="$parent.userAwardswon"></textarea>
                        </div>
                        <div id="buttoncontainer">
                            <button id="accountsubmit" type="submit">Save Changes</button>
                        </div>
                    </form>
                    <h3 class="accountheading">Security</h3>
                    <form ng-submit="newPassword(oldPass, newPass, confirmPass)">
                        <div class="accountrow">
                            <span class="label">Old Password:</span>
                            <input type="password" ng-model="$parent.oldPass" />
                        </div>
                        <div class="accountrow">
                            <span class="label">New Password:</span>
                            <input type="password" ng-model="$parent.newPass" />
                        </div>
                        <div class="accountrow">
                            <span class="label">Confirm Password:</span>
                            <input type="password" ng-model="$parent.confirmPass" />
                        </div>
                        <div id="buttoncontainer">
                            <button id="passsubmit" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
                <div id="search" ng-if="title=='Research Tool'" class="">
                    <input id="cradio" type="radio" name="case" value="country" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
                    <input id="tradio" type="radio" name="case" value="topic" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
                    <input id="comradio" type="radio" name="case" value="committee" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
                    <input id="sradio" type="radio" name="case" value="unstance" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
                    <svg id="simg" viewBox="0 0 430.3 303.3">
                        <style>.a{clip-rule:evenodd;fill-rule:evenodd;}.b{clip-rule:evenodd;fill-rule:evenodd;fill:#FFF;}.c{fill:#EFCF4A;}</style>
                        <path d="M348.2 288.5c11-3.2 21.5-7.3 31.5-12.4 6.3-16.2 11.4-33.7 11.4-33.7l-20.4-37.7c1 2 25.5 36.7 25.5 36.7l-11.6 32.1c17-9.3 32.4-21.2 45.6-35.2-16.5-19.2-35.4-37.5-57-49.8h-5l-20 100zm-126.1-99.9c-21.6 12.3-40.5 30.6-57 49.8 13.4 14.2 29 26.3 46.4 35.6l-11.8-32.5s24.5-34.7 25.5-36.7l-20.4 37.7s5.2 17.8 11.6 34.1c9.8 4.9 20.1 8.9 30.8 12l-20.1-100h-5z" class="a"/>
                        <path d="M226.3 184.9l20.8 103.6c15.7 4.5 32.1 6.9 49.2 7.1h1.3c17.1-.1 33.6-2.6 49.2-7.1l20.8-103.6H226.3z" class="b"/>
                        <path d="M281.6 236.9s5.1 13 6.2 14.8c1.7 3 18.2 3 19.9 0 1-1.8 6.2-14.8 6.2-14.8l.7-6.2c-14.2 2.9-19.3 2.9-33.5 0l.5 6.2z" class="a"/>
                        <path d="M280.1 294.9l10.1-52.9 7.5-.5 7.5.5 10 52.7c-6 .6-12.2.9-18.4.9-5.6 0-11.2-.2-16.7-.7M398 60.4c9-5.6 15.7-14.2 17.4-23.6C418.3 20.7 401.1-.9 378 0c-12.8.5-21.8 9.2-26.4 20.2l-2.7-1.5-7.5-3.8c-14.2-6.7-29.1-10.6-43.8-10.6s-29.5 3.9-43.8 10.6l-7.5 3.8c-1.2.7-2.4 1.3-3.6 2C238.4 9.4 229.3.5 216.3 0c-23-.9-40.3 20.7-37.4 36.8 1.7 9.7 8.7 18.4 18.1 24.1-2.6 3-5.2 6.1-7.9 9.2-14.1 19.8-22.9 41.3-22.9 59.8 0 65.1 77.9 86.8 114.9 92.2 5.7 3 11.1 4.5 16.5 4.5s10.8-1.5 16.5-4.5c37-5.5 114.9-27.1 114.9-92.2 0-18.6-8.7-40-22.9-59.8-2.7-3.3-5.4-6.6-8.1-9.7" class="a"/>
                        <path d="M251.5 106.3c5.9-3.4 13.6-1.4 17 4.6 3.4 5.9 1.4 13.6-4.6 17-5.9 3.4-13.6 1.4-17-4.6-3.4-5.9-1.4-13.5 4.6-17m7.5 2.3c2.5.4 4.8 1.9 6.2 4.2 2.4 4.1 1 9.4-3.2 11.8-4.1 2.4-9.4 1-11.8-3.2-1.4-2.4-1.5-5.1-.6-7.5 1.6 2.4 4.7 3.2 7.2 1.7 2.6-1.3 3.5-4.5 2.2-7zm72.4-2.3c6-3.4 13.6-1.4 17 4.6 3.4 5.9 1.4 13.6-4.6 17-6 3.4-13.6 1.4-17-4.6-3.4-5.9-1.3-13.5 4.6-17zm7.5 2.3c2.5.4 4.8 1.9 6.2 4.2 2.4 4.1 1 9.4-3.2 11.8-4.1 2.4-9.4 1-11.8-3.2-1.4-2.4-1.5-5.1-.6-7.5 1.6 2.4 4.7 3.2 7.2 1.7 2.6-1.3 3.5-4.5 2.2-7zm-41.2-99c-62 0-127.8 76.3-120.9 126.6 5.7 41.4 44.3 65.6 88.4 74.4-4.2-3.7-8.7-8.1-13.5-13.2 22.1 15.2 34.1 22.8 46 22.8s23.9-7.6 46-22.8c-4.8 5-9.3 9.4-13.5 13.2 44.2-8.8 82.7-33 88.4-74.4C425.5 86 359.7 9.6 297.7 9.6zm-59.3 13.8c-3.9-9.4-11.6-16.8-22.3-17.2-9.5-.4-18.5 3.7-24.9 10.6-1.9 2-3.7 4.5-5.1 7.2 18.9-18.6 40-13.7 47.6 2.6 1.5-1.2 3-2.2 4.7-3.2zm117.8-.6c4-9.2 11.5-16.3 22-16.7 9.5-.4 18.5 3.7 24.9 10.6 1.9 2 3.7 4.5 5.1 7.2-18.6-18.4-39.5-13.8-47.3 2-1.5-1-3.1-2.1-4.7-3.1zm-143.7 98.7c-.9 40.2 68.7 21.2 68.4-21.3-.3-30-67.4-24.5-68.4 21.3zm166.9 0c.9 40.2-68.7 21.2-68.4-21.3.3-30 67.4-24.5 68.4 21.3zm-81.7 69.3s2.4-3.9 6.4-4.6c4-.7 13.3 2.5 10.7 8.7-3 7.3-10 11-17.1 11s-14-3.7-17.1-11c-2.5-6.2 6.7-9.4 10.7-8.7 4 .7 6.4 4.6 6.4 4.6zm14.8-41.4c1.9 4-7 13.1-13 14.9v14.9c15.3-.2 30.4-3.3 41.7-9.3 8.7-4.6 11.3-6.6 12-7.4-2.7-1.6-3.8-4.6-1.5-10.1-.2 6.4 8.5 11 14.9 12.3-4.2-.2-8.7-.3-11.8-1.5l-1.3 1.3c-14.5 14.8-27.3 41-48.3 46.3-3.1.8-5.4 1.1-7.6 1.1-2.3 0-4.5-.4-7.6-1.1-21.1-5.2-33.8-31.5-48.3-46.3-.5-.5-1-.9-1.3-1.3-3.2 1.2-7.7 1.3-11.8 1.5 6.5-1.3 15.2-6 14.9-12.3 2.2 5.5 1.2 8.5-1.5 10.1.8.8 3.4 2.9 12.1 7.4 11.3 6 26.5 9.1 41.7 9.3v-14.9c-6-1.8-14.9-10.8-13-14.9 2.6-5.5 27.1-5.5 29.7 0zm-14.8-2c2.8 0 5 .8 5 1.9 0 1-2.3 1.9-5 1.9s-5-.8-5-1.9c-.1-1.1 2.2-1.9 5-1.9zm93.5 95l-19.9-36.8c3.7 5.8 25 35.8 25 35.8l-11.8 32.5-4.9 2.5c6.4-16.2 11.6-34 11.6-34m-186.4 0l19.9-36.8c-3.7 5.8-25 35.8-25 35.8l11.8 32.5 4.9 2.5c-6.4-16.2-11.6-34-11.6-34z" class="b"/>
                        <g id="fitem">
                            <path id="path15" d="M150.75 223.06l-5.4-.57-1.73-2.07c7.6-7.1 12.7-16.82 13.8-27.86 2.6-24.6-15.2-46.63-39.8-49.22-24.6-2.58-46.6 15.26-49.2 39.86-2.6 24.6 15.3 46.65 39.9 49.23 11.1 1.16 21.6-1.82 30.1-7.7l1.7 2.1-.5 5.42 30.7 37.8 11.3-9.15-30.6-37.9zm-41.1-4.32c-17.07-1.8-29.4-17.02-27.6-34.08 1.8-17.06 17-29.4 34.07-27.6 17.1 1.8 29.4 17.02 27.6 34.08-1.8 17.07-17 29.4-34 27.6z"/>
                        </g>
                        <path d="M200 264c-6 6.8-30.2 28-34.7 18.8l-1-2 2.2-.2c4.3-.4 12.3-5.6 15.9-8 4.1-2.8 11.7-8.5 14.6-12.8-.5-6.5-5.3-16.2-12.5-17.5-5.5 5.2-33 29.5-37.2 21.8l-.7-1.3 2-1.1c12.5-6.9 22.5-13.2 32.8-23.2.7-3.4-.2-6.4-1.7-9.5-1-2.1-2.8-3.6-4.8-4.6-9.7-4.9-21.4 4.9-27.8 11.2-4.6 4.5-16.6 16.1-12.9 23.7 2.7 5.6 8.9 7.6 9.9 15.3.4 2.7 1.6 4.6 2.9 6.8 3.2 3.8 10.5 6 12.2 8.1 1.7 3.2 4.1 6.1 7.5 7.6 5.7 2.5 12.5.2 17.8-2.4 3.8-1.8 7.4-4.1 10.8-6.6 9.2-6.5 14.6-15.8 4.7-24.1" class="b"/>
                        <path d="M200 264c-6 6.8-30.2 28-34.7 18.8l-1-2 2.2-.2c4.3-.4 12.3-5.6 15.9-8 4.1-2.8 11.7-8.5 14.6-12.8-.3-4.2-2.1-8.5-4.7-11.9-1.8-2.4-4.7-5-7.8-5.6-5.5 5.2-33 29.5-37.2 21.8l-.7-1.3 2-1.1c12.5-6.9 22.5-13.2 32.8-23.2.7-3.4-.2-6.4-1.7-9.5-1-2.1-2.8-3.6-4.8-4.6-9.7-4.9-21.4 4.9-27.8 11.2-4.6 4.5-16.6 16.1-12.9 23.7 2.7 5.6 8.9 7.6 9.9 15.3.4 2.7 1.6 4.6 2.9 6.8 3.2 3.8 10.5 6 12.2 8.1 1.7 3.2 4.1 6.1 7.5 7.6 5.7 2.5 12.5.2 17.8-2.4 3.8-1.8 7.4-4.1 10.8-6.6 9.2-6.5 14.6-15.8 4.7-24.1m-7.7-26.9c3.7 4.5 6.7 9.6 9.1 17.1 4.8 5.7 6.2 12.8 10 19.8-.3 3.6-2.5 6.7-4.5 9.7-4.5 6.5-13.3 12.4-20.5 15.7-6.3 3-13.7 5.3-20.6 2.9-4.8-1.7-8.3-5.3-10.8-9.6l-6.4-3.4c-6.6-5.3-7-5.4-9.6-13.8-.9-2.9-5.1-6-7.3-8-13.4-12.7.8-26.7 11.4-36.1l4.1-3.3c7.5-6.3 19.8-13.4 29.5-9.6 6.6 2.7 13.5 10.9 15.6 18.6z" class="a"/>
                    </svg>
                    <input id="sbar" type="text" ng-model="$parent.query" ng-focus="searchready()" placeholder="Search" />
                    <div id="soptions">
                        <label class="rlab" for="cradio">
                            Country
                        </label><!--
                        --><label class="rlab" for="tradio">
                            Topic
                        </label><!--
                        --><label class="rlab" for="comradio">
                            Committees
                        </label><!--
                        --><label class="rlab" for="sradio">
                            UN Stance
                        </label>
                    </div>
                    <ul id="searchbox" class="{{sval}}">
                        <div id="s-country" ng-if="$parent.sval=='country'"></div>
                        <div class="tile-res" ng-if="sval=='topic'">
                            <a class="s-tile topic-gs" url-pre="https://scholar.google.ae/scholar?q=" target="_blank">
                                <span>Google Scholar</span>
                            </a>
                            <a class="s-tile topic-w" url-pre="https://en.wikipedia.org/wiki/Special:Search?search=" target="_blank">
                                <span>Wikipedia</span>
                            </a>
                            <a class="s-tile topic-r" url-pre="http://www.reuters.com/search/news?blob=" target="_blank">
                                <span>Reuters</span>
                            </a>
                            <a class="s-tile topic-bbc" url-pre="http://www.bbc.co.uk/search?q=" noplus target="_blank">
                                <span>BBC</span>
                            </a>
                            <a class="s-tile topic-cnn" url-pre="http://edition.cnn.com/search/?text=" target="_blank">
                                <span>CNN</span>
                            </a>
                            <a class="s-tile topic-wsj" url-pre="http://www.wsj.com/search/term.html?KEYWORDS=" noplus target="_blank">
                                <span>WSJ</span>
                            </a>
                            <a class="s-tile topic-nyt" url-pre="http://query.nytimes.com/search/sitesearch/#/" noplus target="_blank">
                                <span>NYT</span>
                            </a>
                            <a class="s-tile topic-aj" url-pre="http://www.aljazeera.com/Search/?q=" noplus target="_blank">
                                <span>Al Jazeera</span>
                            </a>
                        </div>
                        <div class="tile-res" ng-if="sval=='committee'">
                            <a class="s-tile topic-ga" url-pre="http://search.un.org/results.php?tpl=un&cbunFilters_ga=on&query=" target="_blank">
                                <span>General Assembly</span>
                            </a>
                            <a class="s-tile topic-eco" url-pre="http://search.un.org/results.php?tpl=un&cbunFilters_esc=on&query=" target="_blank">
                                <span>Economic and Social Council</span>
                            </a>
                            <a class="s-tile topic-icj" url-pre="http://search.un.org/results.php?tpl=un&cbunFilters_icc=on&query=" target="_blank">
                                <span>International Court of Justice</span>
                            </a>
                            <a class="s-tile topic-tc" url-pre="http://search.un.org/results.php?tpl=un&cbunFilters_tc=on&query=" target="_blank">
                                <span>Trusteeship Council</span>
                            </a>
                            <a class="s-tile topic-sc" url-pre="http://search.un.org/results.php?tpl=un&cbunFilters_sc=on&query=" target="_blank">
                                <span>The Security Council</span>
                            </a>
                            <a class="s-tile topic-ceb" url-pre="http://www.unsceb.org/search/node/" noplus target="_blank">
                                <span>UNSCEB</span>
                            </a>
                            <a class="s-tile topic-wango" url-pre="search.php?wango&q=" noplus target="_blank">
                                <span>WANGO</span>
                            </a>
                        </div>
                        <div class="tile-res" ng-if="sval=='unstance'">
                            <a class="s-tile topic-und" url-pre="http://data.un.org/Search.aspx?q=" target="_blank">
                                <span>UNdata</span>
                            </a>
                            <a class="s-tile topic-dhl" url-pre="http://search.ebscohost.com/login.aspx?direct=true&site=eds-live&scope=site&type=0&custid=s2758984&groupid=UNHQ-HQ&profid=eds&mode=bool&lang=en&authtype=ip,guest&bquery=" noplus target="_blank">
                                <span>Dag Hammarskjöld Library</span>
                            </a>
                            <a class="s-tile topic-sun" url-pre="http://search.un.org/results.php?tpl=dist_search&query=" target="_blank">
                                <span>UN Enterprise Search</span>
                            </a>
                            <a class="s-tile topic-pb" url-pre="http://passblue.com/?s=" target="_blank">
                                <span>PassBlue</span>
                            </a>
                        </div>
                    </ul>
                </div>
                <div id="mash" ng-if="title=='Mash'">
                    <div id="foldername">
                        <a class="back" ng-click="open('Notes')">
                            <i class="fa fa-chevron-left"></i>
                            &nbsp;Exit
                        </a>
                        <span id="nametxt" class="mash-head">MASH Step {{step}}</span>
                    </div>
                    <div id="mashinfo">{{guide}}</div>
                    <div ng-if="step==1">
                        <div ng-click="check($index)" class="mash noteitem item type-{{note.type}}" ng-repeat="note in json.folders[folderindex].notes" ng-attr-title="{{note.name}}" ng-if="!bloc">
                            <span class="text">{{note.name}}</span>
                        </div>
                        <div ng-click="check($index)" class="mash noteitem item type-{{note.type}}" ng-repeat="note in json.blocs[folderindex].notes" ng-attr-title="{{note.name}}" ng-if="bloc">
                            <span class="text">{{note.name}}</span>
                        </div>
                        <button type="button" ng-click="extraFiles()">Continue</button>
                    </div>
                    <div ng-if="step==2">
                        <div ng-click="checkDoc(1)" class="mash noteitem item type-pdf" title="">
                            <span class="text">Note Paper Template</span>
                        </div>
                        <div ng-click="checkDoc(2)" class="mash noteitem item type-pdf" title="Amendment Sheet">
                            <span class="text">Amendment Sheet</span>
                        </div>
                        <div ng-click="checkDoc(3)" class="mash noteitem item type-pdf" title="MUN Phrases">
                            <span class="text">MUN Phrases</span>
                        </div>
                        <button type="button" ng-click="downloadMerged()">Download</button>
                    </div>
                </div>
                <a href="" id="clickdown" download></a>
            </div>
            <div id="modalcontainer" ng-if="modalVisible===true" ng-click="hideModal()">
                <div id="modal">
                    <div id="modalinner" ng-click="$parent.modalClick=true">
                        <i class="fa fa-times" ng-click="hideModal()"></i>
                        <h3>{{modalTitle}}</h3>
                        <div id="modalcontent">
                            {{modalContent}}
                            <div ng-if="modalTitle=='New Folder'">
                                <form ng-submit="createFolder(foldername)">
                                    <input type="text" placeholder="Folder Name" ng-model="foldername" />
                                    <button type="submit">Create Folder</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='New Note'">
                                <div ng-init="notetype=''">
                                    <a class="back" ng-if="notetype=='url'" ng-click="$parent.notetype='';$parent.require();">
                                        <i class="fa fa-chevron-left"></i>
                                        &nbsp;Back
                                    </a>
                                    <input id="notename" type="text" placeholder="Note Name" ng-model="notename" />
                                    <div id="notemenu" ng-if="notetype!='url'">
                                        <button id="texttype" ng-click="createNote(notename, 'text')">
                                            Text-based note
                                        </button>
                                        <button id="urltype" ng-click="$parent.notetype='url'">
                                            URL
                                        </button>
                                    </div>
                                    <form ng-if="notetype=='url'" ng-submit="createNote(notename, notetype, noteURL)">
                                        <input type="text" ng-model="$parent.noteURL" placeholder="URL" />
                                        <button type="submit">Create Note</button>
                                    </form>
                                </div>
                                <div id="drop" ng-if="notetype!='url'">
                                    Image/PDF/Word Doc note
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                        <input name="upload" type="hidden" />
                                    </div>
                                </div>
                            </div>
                            <div ng-if="modalTitle=='Edit Folder'">
                                <form ng-submit="editFolder(foldername,foldercolor)">
                                    <input type="text" placeholder="Folder Name" ng-model="foldername" />
                                    <color-picker ng-model="foldercolor" color-picker-format="'hex'" color-picker-alpha="false" color-picker-swatch-bootstrap="false"></color-picker>
                                    <button type="submit">Save Changes to Folder</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Delete Folder'">
                                <form ng-submit="deleteFolder()">
                                    Are you sure you want to delete the folder - "{{foldername}}"?
                                    <button type="submit">Confirm Deletion</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Edit Note'">
                                <form ng-submit="editNote(notename)">
                                    <input type="text" placeholder="Note Name" ng-model="notename" />
                                    <button type="submit">Save Changes to Note</button>
                                </form>
                            </div>
                            <div ng-if="modalContext=='Referral Code'" id="refcode">
                                The referral code for <b>'{{blocName}}'</b> is
                                <br />
                                <pre>{{refcode}}</pre>
                                <br />
                                Give this code to other delegates to join your bloc.
                            </div>
                            <div ng-if="modalTitle=='Delete Note'">
                                <form ng-submit="deleteNote()">
                                    Are you sure you want to delete the note - "{{notename}}"?
                                    <button type="submit">Confirm Deletion</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Profile Picture'">
                                <div id="picdrop">
                                    Drop New Profile Picture
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                        <input name="upload" type="hidden" />
                                    </div>
                                </div>
                            </div>
                            <div ng-if="modalTitle=='Folder Download'" id="filedownload"></div>
                            <div ng-if="modalTitle=='New Bloc'">
                                <form ng-submit="createBloc(blocname)">
                                    <input type="text" placeholder="Bloc Name" ng-model="blocname" />
                                    <button type="submit">Create Bloc</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Join Bloc'">
                                <form ng-submit="joinBloc(referralcode)">
                                    <input type="text" placeholder="Referral Code" ng-model="referralcode" />
                                    <button type="submit">Join Bloc</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Edit Bloc'">
                                <form ng-submit="editBloc(blocname,bloccolor)">
                                    <input type="text" placeholder="Bloc Name" ng-model="blocname" />
                                    <color-picker ng-model="bloccolor" color-picker-format="'hex'" color-picker-alpha="false" color-picker-swatch-bootstrap="false"></color-picker>
                                    <button type="submit">Save Changes to Bloc</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Leave Bloc'">
                                <form ng-submit="leaveBloc()">
                                    Are you sure you want to leave the bloc - "{{blocname}}"?
                                    <button type="submit">Confirm Leave</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Delete Bloc'">
                                <form ng-submit="deleteBloc()">
                                    Are you sure you want to delete the bloc - "{{blocname}}"?
                                    <button type="submit">Confirm Deletion</button>
                                </form>
                            </div>
                            <div ng-if="modalTitle=='Bloc Download'" id="filedownload"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="dragndrop">
                <div id="dropzone">
                    <button id="hidedrag" onclick="hideNoteMake()">X</button>
                    Image/PDF/Word Doc note
                    <div class="fallback">
                        <input name="file" type="file" />
                        <input name="upload" type="hidden" />
                    </div>
                </div>
            </div>
        </div>
        <?=minJS()?>
    </body>
</html>
