<?php session_start();
include "app-functions.php";
if(!loggedin())
    header("Location: ../");
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <title>App</title>
        <link rel="stylesheet" href="css/icomoon.css" />
        <link rel="stylesheet" href="css/opensans.css" />
<!--        <link rel="stylesheet" href="css/style.css" />-->
        <?=minCSS()?>
        <link rel="stylesheet" href="css/textAngular.min.css" />
        <link rel="stylesheet" href="css/angularjs-color-picker.min.css" />
    </head>
    <body ontouchstart="document.body.className='touch'">
        <div id="container" ng-app="DelegatePal" ng-controller="control">
            <input type="checkbox" id="menub" ng-init="menuVisible=false" ng-model="menuVisible" />
            <div id="masthead">
                <a href="../app/">
                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" height="36.8" width="214" version="1.1" y="0" x="0" enable-background="new 0 0 214.002 36.827" viewBox="0 0 214 36.83" id="brand">
                        <switch>
                            <foreignObject y="0" x="0" height="1" width="1" requiredExtensions="http://ns.adobe.com/AdobeIllustrator/10.0/"/>
                            <g>
                                <path d="m145 15.4h-7.19c0.12-0.79 0.36-1.45 0.73-2 0.37-0.54 0.83-0.95 1.38-1.23s1.16-0.42 1.83-0.42c0.79 0.01 1.42 0.14 1.9 0.39 0.49 0.25 0.84 0.6 1.06 1.03 0.22 0.44 0.33 0.94 0.33 1.5 0 0.12 0 0.25-0.01 0.36v0.4m4 7.7c-0.14-0.25-0.3-0.44-0.47-0.54-0.16-0.11-0.37-0.16-0.6-0.16-0.1 0-0.23 0.01-0.4 0.03-0.17 0.03-0.33 0.06-0.48 0.12-0.77 0.36-1.54 0.64-2.33 0.85s-1.62 0.32-2.5 0.33c-0.91-0.01-1.7-0.16-2.36-0.47-0.65-0.31-1.17-0.74-1.56-1.3s-0.63-1.22-0.73-1.99c-0.02-0.15-0.02-0.34-0.03-0.56s-0.01-0.41-0.01-0.58h10.6c0.25 0 0.48-0.04 0.7-0.13s0.38-0.2 0.48-0.35c0.13-0.19 0.22-0.4 0.27-0.65 0.05-0.24 0.07-0.47 0.07-0.68 0.01-1.16-0.09-2.28-0.31-3.33-0.22-1.06-0.61-2-1.17-2.83s-1.36-1.48-2.39-1.97c-1.03-0.48-2.36-0.72-3.99-0.73-1.24 0-2.4 0.21-3.51 0.63-1.1 0.42-2.08 1.05-2.94 1.89-0.85 0.84-1.53 1.89-2.02 3.17-0.49 1.27-0.74 2.76-0.75 4.46 0.01 1.41 0.2 2.69 0.58 3.86 0.38 1.16 0.94 2.17 1.67 3.01s1.62 1.5 2.68 1.96c1.05 0.46 2.26 0.7 3.6 0.7 0.97 0 1.88-0.08 2.74-0.24 0.85-0.15 1.69-0.38 2.48-0.68s1.57-0.66 2.34-1.08c0.27-0.13 0.47-0.31 0.62-0.53s0.23-0.47 0.23-0.76c0.01-0.18-0.02-0.4-0.08-0.65 0-0.3 0-0.5-1-0.8zm-18 1c-0.08-0.34-0.23-0.56-0.46-0.67-0.23-0.1-0.48-0.15-0.76-0.14-0.19 0.01-0.44 0.02-0.76 0.06-0.31 0.03-0.64 0.05-0.98 0.06-0.43 0-0.8-0.06-1.12-0.19-0.31-0.12-0.56-0.31-0.73-0.55-0.14-0.18-0.24-0.4-0.32-0.66s-0.14-0.58-0.17-0.96c-0.04-0.39-0.05-0.85-0.05-1.4v-7h3.36c0.46-0.01 0.81-0.13 1.03-0.37 0.23-0.25 0.34-0.6 0.34-1.06v-0.96c0-0.48-0.11-0.84-0.34-1.08-0.22-0.24-0.56-0.36-1.03-0.36h-3.36v-3.41c0-0.49-0.12-0.85-0.36-1.08-0.23-0.22-0.58-0.33-1.04-0.33-0.08 0-0.23 0.01-0.46 0.01-0.23 0.01-0.47 0.02-0.75 0.04-0.27 0.02-0.52 0.04-0.75 0.06-0.28 0.04-0.52 0.14-0.71 0.3s-0.34 0.36-0.44 0.58c-0.1 0.23-0.16 0.48-0.17 0.74-0.04 0.66-0.07 1.2-0.09 1.62s-0.04 0.74-0.05 0.97v0.52c-0.26 0-0.61 0.01-1.02 0.03-0.42 0.03-0.85 0.06-1.3 0.12-0.39 0.03-0.69 0.17-0.91 0.41s-0.33 0.59-0.34 1.07v0.78c0 0.46 0.12 0.82 0.35 1.06 0.23 0.25 0.57 0.37 1.01 0.38h2.18v8.49c0 0.78 0.04 1.46 0.1 2.04 0.07 0.58 0.19 1.09 0.35 1.52s0.36 0.82 0.62 1.16c0.26 0.36 0.6 0.67 1.01 0.92 0.42 0.25 0.88 0.44 1.4 0.58 0.52 0.13 1.06 0.2 1.65 0.2 0.79 0 1.52-0.03 2.19-0.1 0.68-0.07 1.32-0.18 1.94-0.34 0.2-0.05 0.39-0.13 0.56-0.24s0.31-0.25 0.42-0.42c0.1-0.16 0.16-0.35 0.17-0.56 0-0.28-0.01-0.58-0.04-0.89 1-0.3 1-0.6 1-0.9zm-21-1.4c-0.32 0.27-0.68 0.52-1.09 0.73-0.4 0.22-0.82 0.39-1.27 0.52-0.44 0.12-0.89 0.19-1.33 0.19-0.51 0-0.95-0.08-1.34-0.25-0.39-0.16-0.69-0.42-0.91-0.76-0.21-0.35-0.33-0.8-0.33-1.35 0-0.48 0.12-0.88 0.38-1.2 0.25-0.32 0.64-0.58 1.18-0.79 0.45-0.16 0.95-0.28 1.51-0.37 0.55-0.09 1.11-0.17 1.67-0.21s1.08-0.07 1.54-0.08v3.6zm4 0.9v-8.41c0-0.88-0.03-1.64-0.1-2.28s-0.17-1.19-0.31-1.64c-0.13-0.45-0.31-0.85-0.52-1.17-0.41-0.66-1.03-1.16-1.86-1.48s-1.86-0.48-3.08-0.48c-0.45 0-0.98 0.02-1.59 0.08-0.6 0.05-1.24 0.14-1.92 0.24s-1.36 0.23-2.05 0.38-1.36 0.32-2 0.52c-0.36 0.11-0.63 0.26-0.84 0.47-0.2 0.21-0.3 0.5-0.31 0.86 0 0.26 0.02 0.52 0.07 0.79 0.04 0.27 0.12 0.52 0.23 0.76 0.11 0.22 0.23 0.39 0.38 0.52 0.14 0.12 0.33 0.18 0.54 0.18 0.07 0 0.17-0.01 0.3-0.02 0.14-0.02 0.27-0.03 0.41-0.05s0.25-0.03 0.33-0.04c0.65-0.13 1.29-0.25 1.92-0.34s1.21-0.17 1.75-0.21c0.54-0.05 0.99-0.07 1.35-0.07 0.64-0.01 1.13 0.06 1.47 0.18s0.59 0.32 0.74 0.6c0.15 0.21 0.25 0.52 0.3 0.92 0.06 0.41 0.08 0.86 0.07 1.37v0.7c-1.44 0.02-2.82 0.11-4.13 0.28-1.3 0.17-2.49 0.42-3.55 0.75-0.71 0.22-1.33 0.56-1.86 1.01-0.53 0.46-0.95 1.01-1.25 1.67s-0.45 1.41-0.46 2.26c0 0.75 0.12 1.46 0.36 2.15 0.25 0.69 0.61 1.3 1.11 1.85s1.12 0.98 1.88 1.3 1.65 0.49 2.67 0.49c0.62 0 1.25-0.09 1.89-0.25 0.65-0.17 1.27-0.42 1.9-0.77 0.62-0.35 1.2-0.79 1.75-1.33l0.07 0.92c0.05 0.47 0.2 0.8 0.47 0.98 0.26 0.19 0.59 0.28 0.97 0.27 0.56 0 1.14-0.03 1.73-0.09 0.59-0.05 1.16-0.12 1.72-0.21s1.07-0.17 1.53-0.26c0.35-0.07 0.62-0.24 0.8-0.49s0.27-0.58 0.27-0.98v-0.48c0-0.48-0.12-0.84-0.35-1.08s-0.57-0.36-1.01-0.36h-3zm-23.7-8.6c0 1.07-0.26 1.86-0.78 2.39s-1.28 0.79-2.28 0.79c-0.58 0-1.1-0.11-1.54-0.34-0.45-0.23-0.8-0.57-1.06-1.03-0.25-0.47-0.38-1.05-0.39-1.77 0-0.58 0.1-1.11 0.32-1.6 0.22-0.5 0.55-0.9 1-1.2 0.45-0.31 1.03-0.47 1.75-0.47 0.77 0.01 1.37 0.16 1.81 0.46s0.74 0.69 0.92 1.18c0.2 0.5 0.3 1 0.3 1.6zm-5.5 13.1l3.43 0.26c0.85 0.07 1.52 0.2 2.01 0.39 0.49 0.2 0.82 0.45 1.02 0.76s0.3 0.69 0.29 1.13c0.01 0.41-0.13 0.81-0.42 1.18-0.28 0.38-0.73 0.68-1.34 0.92s-1.42 0.36-2.41 0.37c-1.03 0-1.88-0.1-2.55-0.29-0.66-0.19-1.16-0.45-1.48-0.79s-0.48-0.72-0.48-1.17c-0.01-0.52 0.14-1.02 0.45-1.48 0.4-0.5 0.9-0.9 1.5-1.3zm-0.3-6.8c0.37 0.11 0.79 0.19 1.26 0.25 0.46 0.06 0.93 0.09 1.4 0.09 1.11 0 2.13-0.14 3.06-0.41 0.94-0.28 1.76-0.68 2.46-1.22s1.24-1.22 1.64-2.03c0.39-0.81 0.59-1.76 0.59-2.83 0.01-0.39-0.03-0.8-0.12-1.22-0.08-0.42-0.24-0.84-0.47-1.25h1.59c0.46-0.01 0.82-0.13 1.06-0.37 0.25-0.25 0.38-0.6 0.38-1.06v-0.77c0-0.46-0.13-0.81-0.38-1.04-0.24-0.24-0.6-0.36-1.06-0.36h-4.21c-0.31-0.17-0.67-0.33-1.07-0.45-0.4-0.13-0.87-0.23-1.4-0.29-0.53-0.07-1.16-0.1-1.88-0.1-1.4 0.01-2.61 0.2-3.62 0.58s-1.84 0.9-2.49 1.55-1.12 1.39-1.44 2.21c-0.31 0.82-0.46 1.69-0.46 2.6 0 0.73 0.1 1.42 0.3 2.07s0.5 1.24 0.9 1.77c0.39 0.54 0.88 0.98 1.46 1.36-0.55 0.59-1 1.12-1.33 1.59-0.34 0.47-0.58 0.92-0.73 1.32s-0.23 0.78-0.23 1.15c0 0.71 0.19 1.33 0.59 1.88 0.39 0.54 1.01 0.94 1.85 1.19-0.9 0.41-1.64 0.84-2.2 1.29-0.55 0.45-0.96 0.94-1.22 1.45s-0.39 1.05-0.38 1.61c-0.01 0.63 0.13 1.25 0.41 1.85s0.73 1.14 1.37 1.62c0.63 0.48 1.49 0.87 2.56 1.15s2.39 0.43 3.97 0.44c1.64-0.01 3.1-0.18 4.37-0.53 1.27-0.36 2.34-0.85 3.22-1.49 0.87-0.64 1.53-1.4 1.99-2.27 0.45-0.87 0.68-1.82 0.68-2.86 0.01-1-0.17-1.87-0.53-2.61s-0.95-1.35-1.75-1.81c-0.81-0.46-1.88-0.77-3.22-0.93l-6.12-0.7c-0.41-0.05-0.73-0.13-0.94-0.25-0.21-0.11-0.36-0.24-0.43-0.38-0.07-0.15-0.11-0.3-0.1-0.44-0.01-0.17 0.04-0.37 0.14-0.59 0-0.3 0.1-0.5 0.4-0.7zm-12.5-5.9h-7.2c0.12-0.79 0.36-1.45 0.73-2 0.37-0.54 0.83-0.95 1.38-1.23s1.16-0.42 1.83-0.42c0.79 0.01 1.42 0.14 1.9 0.39 0.49 0.25 0.84 0.6 1.06 1.03 0.22 0.44 0.33 0.94 0.33 1.5 0 0.12 0 0.25-0.01 0.36v0.4zm4.2 7.7c-0.14-0.25-0.3-0.44-0.47-0.54-0.17-0.11-0.37-0.16-0.6-0.16-0.1 0-0.23 0.01-0.4 0.03-0.17 0.03-0.33 0.06-0.48 0.12-0.77 0.36-1.54 0.64-2.33 0.85s-1.62 0.32-2.5 0.33c-0.91-0.01-1.7-0.16-2.36-0.47-0.65-0.31-1.17-0.74-1.56-1.3s-0.63-1.22-0.73-1.99c-0.02-0.15-0.02-0.34-0.03-0.56s-0.01-0.41-0.01-0.58h10.6c0.25 0 0.48-0.04 0.7-0.13s0.38-0.2 0.48-0.35c0.13-0.19 0.22-0.4 0.27-0.65 0.05-0.24 0.07-0.47 0.07-0.68 0.01-1.16-0.09-2.28-0.31-3.33-0.22-1.06-0.61-2-1.17-2.83s-1.36-1.48-2.39-1.97c-1.03-0.48-2.36-0.72-3.99-0.73-1.24 0-2.4 0.21-3.51 0.63s-2.08 1.05-2.94 1.89c-0.85 0.84-1.53 1.89-2.02 3.17-0.49 1.27-0.74 2.76-0.75 4.46 0.01 1.41 0.2 2.69 0.58 3.86 0.38 1.16 0.93 2.17 1.67 3.01 0.73 0.84 1.62 1.5 2.68 1.96 1.05 0.46 2.26 0.7 3.61 0.7 0.97 0 1.88-0.08 2.74-0.24 0.86-0.15 1.69-0.38 2.48-0.68s1.57-0.66 2.34-1.08c0.27-0.13 0.47-0.31 0.62-0.53s0.23-0.47 0.23-0.76c0.01-0.18-0.02-0.4-0.08-0.65-0.3-0.2-0.4-0.4-0.5-0.7zm-18 2.7v-0.55c0-0.44-0.12-0.77-0.34-1.01-0.23-0.23-0.56-0.37-0.98-0.43l-2-0.2v-22.2c-0.01-0.46-0.13-0.8-0.37-1.03-0.3-0.26-0.6-0.37-0.9-0.37-0.31 0-0.69 0.02-1.14 0.07-0.45 0.06-0.94 0.12-1.46 0.21-0.53 0.09-1.06 0.18-1.59 0.3-0.53 0.1-1.04 0.22-1.52 0.35-0.36 0.09-0.66 0.27-0.89 0.52-0.23 0.26-0.36 0.6-0.36 1.03v0.55c0.01 0.46 0.14 0.82 0.38 1.06 0.25 0.25 0.59 0.38 1.02 0.38h2.07v19.1l-1.88 0.26c-0.42 0.06-0.74 0.2-0.95 0.43-0.2 0.23-0.31 0.57-0.31 1.01v0.55c0.01 0.46 0.13 0.81 0.37 1.05 0.25 0.24 0.59 0.36 1.03 0.36h8.45c0.46 0 0.81-0.12 1.05-0.36 0.3-0.2 0.4-0.5 0.4-1zm-17.7-10.4h-7.19c0.12-0.79 0.36-1.45 0.73-2 0.37-0.54 0.83-0.95 1.38-1.23s1.16-0.42 1.83-0.42c0.79 0.01 1.42 0.14 1.9 0.39 0.49 0.25 0.84 0.6 1.06 1.03 0.22 0.44 0.33 0.94 0.33 1.5 0 0.12 0 0.25-0.01 0.36v0.4zm4.1 7.7c-0.14-0.25-0.3-0.44-0.47-0.54-0.17-0.11-0.37-0.16-0.6-0.16-0.1 0-0.23 0.01-0.4 0.03-0.17 0.03-0.33 0.06-0.48 0.12-0.77 0.36-1.54 0.64-2.33 0.85s-1.62 0.32-2.5 0.33c-0.91-0.01-1.7-0.16-2.36-0.47-0.65-0.31-1.17-0.74-1.56-1.3s-0.63-1.22-0.73-1.99c-0.02-0.15-0.02-0.34-0.03-0.56s-0.01-0.41-0.01-0.58h10.6c0.25 0 0.48-0.04 0.7-0.13s0.38-0.2 0.48-0.35c0.13-0.19 0.22-0.4 0.27-0.65 0.05-0.24 0.07-0.47 0.07-0.68 0.01-1.16-0.09-2.28-0.31-3.33-0.22-1.06-0.61-2-1.17-2.83s-1.36-1.48-2.39-1.97c-1.03-0.48-2.36-0.72-3.99-0.73-1.24 0-2.4 0.21-3.51 0.63s-2.08 1.05-2.94 1.89c-0.85 0.84-1.53 1.89-2.02 3.17-0.49 1.27-0.74 2.76-0.75 4.46 0.01 1.41 0.2 2.69 0.58 3.86 0.38 1.16 0.94 2.17 1.67 3.01s1.62 1.5 2.68 1.96c1.05 0.46 2.26 0.7 3.6 0.7 0.97 0 1.88-0.08 2.74-0.24 0.85-0.15 1.69-0.38 2.48-0.68s1.57-0.66 2.34-1.08c0.27-0.13 0.47-0.31 0.62-0.53s0.23-0.47 0.23-0.76c0.01-0.18-0.02-0.4-0.08-0.65-0.2-0.2-0.3-0.4-0.5-0.7zm-35.7-0.2v-16.3h2.14c1.13-0.01 2.19 0.07 3.17 0.25s1.85 0.5 2.59 0.97c0.64 0.41 1.16 0.94 1.55 1.59 0.4 0.65 0.69 1.39 0.87 2.21s0.28 1.71 0.27 2.65c0.01 1.38-0.12 2.61-0.37 3.67-0.26 1.07-0.68 1.97-1.27 2.69-0.58 0.72-1.36 1.26-2.34 1.61-0.45 0.16-0.95 0.29-1.49 0.39-0.53 0.1-1.09 0.17-1.66 0.21-0.57 0.05-1.13 0.07-1.69 0.07h-1.77zm-7.42 4.3h6.38c1.26 0.01 2.49-0.01 3.7-0.06 1.21-0.04 2.36-0.15 3.44-0.31 1.09-0.16 2.09-0.42 3.01-0.77 1.73-0.66 3.12-1.57 4.16-2.71 1.03-1.14 1.78-2.5 2.23-4.08 0.46-1.58 0.68-3.36 0.66-5.34-0.01-2.22-0.37-4.09-1.07-5.6s-1.69-2.72-2.96-3.62-2.77-1.53-4.49-1.89c-0.58-0.12-1.28-0.23-2.09-0.31s-1.7-0.14-2.66-0.18-1.96-0.06-3-0.06h-7.34c-0.44 0-0.79 0.12-1.08 0.36-0.28 0.32-0.42 0.69-0.43 1.17v0.52c0.01 0.46 0.14 0.81 0.41 1.06 0.26 0.25 0.62 0.4 1.07 0.46l2.32 0.25v17.5l-2.33 0.26c-0.45 0.04-0.81 0.18-1.07 0.42-0.26 0.3-0.39 0.6-0.4 1.1v0.55c0.01 0.44 0.15 0.79 0.42 1.03 0.28 0.3 0.64 0.4 1.09 0.4z"/>
                                <path id="brandblue" d="m214 25.8v-0.55c0-0.44-0.12-0.77-0.34-1.01-0.23-0.23-0.56-0.37-0.98-0.43l-1.99-0.26v-22.1c-0.01-0.46-0.13-0.8-0.37-1.03-1-0.26-1-0.37-2-0.37-0.31 0-0.69 0.02-1.14 0.07-0.45 0.06-0.94 0.12-1.46 0.21-0.53 0.09-1.06 0.18-1.59 0.3-0.53 0.1-1.04 0.22-1.52 0.35-0.36 0.09-0.66 0.27-0.89 0.52s-0.36 0.6-0.36 1.03v0.55c0.01 0.46 0.14 0.82 0.38 1.06 0.25 0.25 0.59 0.38 1.02 0.38h2.07v19.1l-1.88 0.26c-0.42 0.06-0.74 0.2-0.95 0.43-0.2 0.23-0.31 0.57-0.31 1.01v0.55c0.01 0.46 0.13 0.81 0.37 1.05 0.25 0.24 0.59 0.36 1.03 0.36h8.45c0.46 0 0.81-0.12 1.05-0.36 2-0.2 2-0.5 2-1m-20-3.1c-0.32 0.27-0.68 0.52-1.09 0.73-0.4 0.22-0.82 0.39-1.27 0.52-0.44 0.12-0.89 0.19-1.33 0.19-0.51 0-0.95-0.08-1.34-0.25-0.39-0.16-0.69-0.42-0.91-0.76-0.22-0.35-0.33-0.8-0.33-1.35 0-0.48 0.12-0.88 0.38-1.2 0.25-0.32 0.64-0.58 1.18-0.79 0.45-0.16 0.95-0.28 1.51-0.37 0.55-0.09 1.11-0.17 1.67-0.21s1.08-0.07 1.54-0.08v3.6zm5 0.9v-8.41c0-0.88-0.03-1.64-0.1-2.28s-0.17-1.19-0.31-1.64c-0.13-0.45-0.31-0.85-0.52-1.17-0.41-0.66-1.03-1.16-1.86-1.48s-1.86-0.48-3.08-0.48c-0.45 0-0.98 0.02-1.59 0.08-0.6 0.05-1.24 0.14-1.92 0.24s-1.36 0.23-2.05 0.38-1.36 0.32-2 0.52c-0.36 0.11-0.63 0.26-0.84 0.47-0.2 0.21-0.3 0.5-0.31 0.86 0 0.26 0.02 0.52 0.07 0.79 0.04 0.27 0.12 0.52 0.23 0.76 0.11 0.22 0.23 0.39 0.38 0.52 0.14 0.12 0.33 0.18 0.54 0.18 0.07 0 0.17-0.01 0.3-0.02 0.14-0.02 0.27-0.03 0.41-0.05s0.25-0.03 0.33-0.04c0.65-0.13 1.29-0.25 1.92-0.34s1.21-0.17 1.75-0.21c0.54-0.05 0.99-0.07 1.35-0.07 0.64-0.01 1.13 0.06 1.47 0.18s0.59 0.32 0.75 0.6c0.15 0.21 0.25 0.52 0.3 0.92 0.06 0.41 0.08 0.86 0.07 1.37v0.7c-1.44 0.02-2.82 0.11-4.13 0.28-1.3 0.17-2.49 0.42-3.55 0.75-0.71 0.22-1.33 0.56-1.86 1.01-0.53 0.46-0.95 1.01-1.25 1.67s-0.45 1.41-0.46 2.26c0 0.75 0.12 1.46 0.36 2.15 0.25 0.69 0.62 1.3 1.11 1.85 0.5 0.55 1.12 0.98 1.88 1.3s1.65 0.49 2.67 0.49c0.62 0 1.25-0.09 1.9-0.25 0.65-0.17 1.27-0.42 1.9-0.77 0.62-0.35 1.2-0.79 1.75-1.33l0.07 0.92c0.05 0.47 0.2 0.8 0.47 0.98 0.27 0.19 0.59 0.28 0.97 0.27 0.56 0 1.14-0.03 1.73-0.09 0.59-0.05 1.16-0.12 1.72-0.21s1.07-0.17 1.53-0.26c0.35-0.07 0.62-0.24 0.8-0.49s0.27-0.58 0.27-0.98v-0.48c0-0.48-0.12-0.84-0.35-1.08s-0.57-0.36-1.01-0.36h-1zm-30-10.2v-6.98h2.32c0.73 0 1.4 0.04 2 0.14 0.6 0.09 1.11 0.23 1.5 0.42 0.5 0.25 0.89 0.6 1.17 1.08s0.42 1.04 0.42 1.69c-0.01 0.83-0.18 1.52-0.54 2.07s-0.85 0.95-1.49 1.21c-0.26 0.1-0.58 0.18-0.94 0.23-0.36 0.06-0.74 0.1-1.14 0.14-0.4 0.02-0.79 0.04-1.16 0.04h-2zm4 12.4v-0.55c0-0.44-0.11-0.79-0.34-1.03-0.22-0.24-0.56-0.37-1.03-0.41l-2.99-0.26v-6.05h2.1c1.02 0.01 2.02-0.04 3-0.14s1.9-0.29 2.75-0.56c1.66-0.58 2.91-1.47 3.74-2.68 0.83-1.2 1.24-2.7 1.24-4.48 0-1.3-0.18-2.4-0.56-3.32-0.37-0.92-0.94-1.66-1.7-2.24s-1.72-1.01-2.87-1.3c-0.39-0.1-0.87-0.19-1.43-0.25-0.56-0.07-1.16-0.12-1.8-0.16s-1.27-0.07-1.9-0.08c-0.63-0.02-1.21-0.02-1.74-0.02h-8.23c-0.45 0-0.81 0.12-1.09 0.36s-0.42 0.6-0.42 1.08v0.52c0.01 0.46 0.14 0.81 0.41 1.06s0.62 0.4 1.07 0.46l2.32 0.26v17.8l-2.32 0.22c-0.45 0.04-0.81 0.18-1.07 0.42-0.26 0.25-0.4 0.6-0.4 1.06v0.55c0.01 0.44 0.15 0.79 0.42 1.03 0.28 0.24 0.64 0.36 1.09 0.37h10.3c0.45 0 0.79-0.12 1.03-0.36v-1z" fill="#23a0bf"/>
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
                        <img ng-src="{{noteinfo.data}}" />
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
                    <img id="simg" src="img/logos/DelegatePal1.svg" />
                    <input id="sbar" type="text" ng-model="$parent.query" ng-focus="searchready()" placeholder="Search" />
                    <input id="cradio" type="radio" name="case" value="country" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
                    <input id="tradio" type="radio" name="case" value="topic" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
                    <input id="comradio" type="radio" name="case" value="committee" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
                    <input id="sradio" type="radio" name="case" value="unstance" ng-model="$parent.sval" class="srad" ng-click="search(sval, query)" />
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
                <iframe src="" id="iniframe"></iframe>
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
        <script src="js/angular.min.js"></script>
        <script src="js/textAngular-rangy.min.js"></script>
        <script src="js/textAngular-sanitize.min.js"></script>
        <script src="js/textAngular.min.js"></script>
        <script src="js/dropzone.js"></script>
        <script src="js/jszip.min.js"></script>
        <script src="js/tinycolor.min.js"></script>
        <script src="js/angularjs-color-picker.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>