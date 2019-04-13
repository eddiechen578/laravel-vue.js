
@extends('layouts.app')

@section('content')
    <chat-component></chat-component>
@endsection


@section('styles')
    <style>

        html,
        body,
        div,
        span {
            height: 100%;
            width: 100%;
            /*overflow: hidden;*/
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: url("http://shurl.esy.es/y") no-repeat fixed center;
            background-size: cover;
        }

        .fa-2x {
            font-size: 1.5em;
        }

        .app {
            position: relative;
            overflow: hidden;
            top: 19px;
            height: calc(100% - 38px);
            margin: auto;
            padding: 0;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
        }

        .app-one {
            background-color: #f7f7f7;
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
        }

        .side {
            padding: 0;
            margin: 0;
            height: 100%;
        }
        .side-one {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            position: relative;
            display: block;
            top: 0;
        }

        .side-two {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: 2;
            position: relative;
            top: -100%;
            left: -100%;
            -webkit-transition: left 0.3s ease;
            transition: left 0.3s ease;

        }


        .heading {
            padding: 10px 16px 10px 15px;
            margin: 0;
            height: 60px;
            width: 100%;
            background-color: #eee;
            z-index: 1000;
        }

        .heading-avatar {
            padding: 0;
            cursor: pointer;

        }

        .heading-avatar-icon img {
            border-radius: 50%;
            height: 40px;
            width: 40px;
        }

        .heading-name {
            padding: 0 !important;
            cursor: pointer;
        }

        .heading-name-meta {
            font-weight: 700;
            font-size: 100%;
            padding: 5px;
            padding-bottom: 0;
            text-align: left;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #000;
            display: block;
        }
        .heading-online {
            display: none;
            padding: 0 5px;
            font-size: 12px;
            color: #93918f;
        }
        .heading-compose {
            padding: 0;
        }

        .heading-compose i {
            text-align: center;
            padding: 5px;
            color: #93918f;
            cursor: pointer;
        }

        .heading-dot {
            padding: 0;
            margin-left: 10px;
        }

        .heading-dot i {
            text-align: right;
            padding: 5px;
            color: #93918f;
            cursor: pointer;
        }

        .searchBox {
            padding: 0 !important;
            margin: 0 !important;
            height: 60px;
            width: 100%;
        }

        .searchBox-inner {
            height: 100%;
            width: 100%;
            padding: 10px !important;
            background-color: #fbfbfb;
        }


        /*#searchBox-inner input {
          box-shadow: none;
        }*/

        .searchBox-inner input:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

        .sideBar {
            padding: 0 !important;
            margin: 0 !important;
            background-color: #fff;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 120px);
        }

        .sideBar-body {
            position: relative;
            padding: 10px !important;
            border-bottom: 1px solid #f7f7f7;
            height: 72px;
            margin: 0 !important;
            cursor: pointer;
        }

        .sideBar-body:hover {
            background-color: #f2f2f2;
        }

        .sideBar-avatar {
            text-align: center;
            padding: 0 !important;
        }

        .avatar-icon img {
            border-radius: 50%;
            height: 49px;
            width: 49px;
        }

        .sideBar-main {
            padding: 0 !important;
        }

        .sideBar-main .row {
            padding: 0 !important;
            margin: 0 !important;
        }

        .sideBar-name {
            padding: 10px !important;
        }

        .name-meta {
            font-size: 100%;
            padding: 1% !important;
            text-align: left;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #000;
        }

        .sideBar-time {
            padding: 12px !important;
        }

        .time-meta {
            text-align: right;
            font-size: 12px;
            padding: 1% !important;
            color: rgba(0, 0, 0, .4);
            vertical-align: baseline;
        }

        /*New Message*/

        .newMessage {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            position: relative;
            left: -100%;
        }
        .newMessage-heading {
            padding: 10px 16px 10px 15px !important;
            margin: 0 !important;
            height: 100px;
            width: 100%;
            background-color: #00bfa5;
            z-index: 1001;
        }

        .newMessage-main {
            padding: 10px 16px 0 15px !important;
            margin: 0 !important;
            height: 60px;
            margin-top: 30px !important;
            width: 100%;
            z-index: 1001;
            color: #fff;
        }

        .newMessage-title {
            font-size: 18px;
            font-weight: 700;
            padding: 10px 5px !important;
        }
        .newMessage-back {
            text-align: center;
            vertical-align: baseline;
            padding: 12px 5px !important;
            display: block;
            cursor: pointer;
        }
        .newMessage-back i {
            margin: auto !important;
        }

        .composeBox {
            padding: 0 !important;
            margin: 0 !important;
            height: 60px;
            width: 100%;
        }

        .composeBox-inner {
            height: 100%;
            width: 100%;
            padding: 10px !important;
            background-color: #fbfbfb;
        }

        .composeBox-inner input:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

        .compose-sideBar {
            padding: 0 !important;
            margin: 0 !important;
            background-color: #fff;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 160px);
        }

        /*Conversation*/

        .conversation {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            /*width: 100%;*/
            border-left: 1px solid rgba(0, 0, 0, .08);
            /*overflow-y: auto;*/
        }

        .message {
            padding: 0 !important;
            margin: 0 !important;
            background: url("") no-repeat fixed center;
            background-size: cover;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 120px);
        }
        .message-previous {
            margin : 0 !important;
            padding: 0 !important;
            height: auto;
            width: 100%;
        }
        .previous {
            font-size: 15px;
            text-align: center;
            padding: 10px !important;
            cursor: pointer;
        }

        .previous a {
            text-decoration: none;
            font-weight: 700;
        }

        .message-body {
            margin: 0 !important;
            padding: 0 !important;
            width: auto;
            height: auto;
        }

        .message-main-receiver {
            padding: 10px 20px;
            max-width: 60%;
        }

        .message-main-sender {
            padding: 3px 20px !important;
            margin-left: 40% !important;
            max-width: 60%;
        }
        .message-read {
            margin: 0 !important;
            margin-left: 10px !important;
            font-size: 12px;
            text-align: right;
            color: #9a9a9a;
        }

        .message-text {
            margin: 0 !important;
            padding: 5px !important;
            word-wrap:break-word;
            font-weight: 200;
            font-size: 14px;
            padding-bottom: 0 !important;
        }

        .message-time {
            margin: 0 !important;
            margin-left: 20px !important;
            font-size: 12px;
            text-align: right;
            color: #9a9a9a;

        }

        .receiver {
            width: auto !important;
            padding: 4px 10px 7px !important;
            border-radius: 10px 10px 10px 0;
            background: #ffffff;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            word-wrap: break-word;
            display: inline-block;
        }

        .sender {
            float: right;
            width: auto !important;
            background: #dcf8c6;
            border-radius: 10px 10px 0 10px;
            padding: 4px 10px 7px !important;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            display: inline-block;
            word-wrap: break-word;
        }


        /*Reply*/

        .reply {
            height: 60px;
            width: 100%;
            background-color: #f5f1ee;
            padding: 10px 5px 10px 5px !important;
            margin: 0 !important;
            z-index: 1000;
        }

        .reply-emojis {
            padding: 5px !important;
        }

        .reply-emojis i {
            text-align: center;
            padding: 5px 5px 5px 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-recording {
            padding: 5px !important;
        }

        .reply-recording i {
            text-align: center;
            padding: 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-send {
            padding: 5px !important;
        }

        .reply-send i {
            text-align: center;
            padding: 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-main {
            padding: 2px 5px !important;
        }

        .reply-main textarea {
            width: 100%;
            resize: none;
            overflow: hidden;
            padding: 5px !important;
            outline: none;
            border: none;
            text-indent: 5px;
            box-shadow: none;
            height: 100%;
            font-size: 16px;
        }

        .reply-main textarea:focus {
            outline: none;
            border: none;
            text-indent: 5px;
            box-shadow: none;
        }

        @media screen and (max-width: 700px) {
            .app {
                top: 0;
                height: 100%;
            }
            .heading {
                height: 70px;
                background-color: #009688;
            }
            .fa-2x {
                font-size: 2.3em !important;
            }
            .heading-avatar {
                padding: 0 !important;
            }
            .heading-avatar-icon img {
                height: 50px;
                width: 50px;
            }
            .heading-compose {
                padding: 5px !important;
            }
            .heading-compose i {
                color: #fff;
                cursor: pointer;
            }
            .heading-dot {
                padding: 5px !important;
                margin-left: 10px !important;
            }
            .heading-dot i {
                color: #fff;
                cursor: pointer;
            }
            .sideBar {
                height: calc(100% - 130px);
            }
            .sideBar-body {
                height: 80px;
            }
            .sideBar-avatar {
                text-align: left;
                padding: 0 8px !important;
            }
            .avatar-icon img {
                height: 55px;
                width: 55px;
            }
            .sideBar-main {
                padding: 0 !important;
            }
            .sideBar-main .row {
                padding: 0 !important;
                margin: 0 !important;
            }
            .sideBar-name {
                padding: 10px 5px !important;
            }
            .name-meta {
                font-size: 16px;
                padding: 5% !important;
            }
            .sideBar-time {
                padding: 10px !important;
            }
            .time-meta {
                text-align: right;
                font-size: 14px;
                padding: 4% !important;
                color: rgba(0, 0, 0, .4);
                vertical-align: baseline;
            }
            /*Conversation*/
            .conversation {
                padding: 0 !important;
                margin: 0 !important;
                height: 100%;
                /*width: 100%;*/
                border-left: 1px solid rgba(0, 0, 0, .08);
                /*overflow-y: auto;*/
            }
            .message {
                height: calc(100% - 140px);
            }
            .reply {
                height: 70px;
            }
            .reply-emojis {
                padding: 5px 0 !important;
            }
            .reply-emojis i {
                padding: 5px 2px !important;
                font-size: 1.8em !important;
            }
            .reply-main {
                padding: 2px 8px !important;
            }
            .reply-main textarea {
                padding: 8px !important;
                font-size: 18px;
            }
            .reply-recording {
                padding: 5px 0 !important;
            }
            .reply-recording i {
                padding: 5px 0 !important;
                font-size: 1.8em !important;
            }
            .reply-send {
                padding: 5px 0 !important;
            }
            .reply-send i {
                padding: 5px 2px 5px 0 !important;
                font-size: 1.8em !important;
            }
        }
    </style>
@stop

@section('scripts')
    <script>

    </script>
@stop
