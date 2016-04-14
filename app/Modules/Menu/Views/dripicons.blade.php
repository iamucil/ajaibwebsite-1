@extends('layouts.blank')
@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/dripicon.css') }}">
    <style type="text/css">
    a{
        color: #444444 !important;
    }
    </style>
@stop
@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="menuLabelModal">Icon Pack</h4>
    </div>
    <div class="modal-body">
        <section data-valign="center">
            <div class="entypo-tooltip">
                <ul class="icon-packs">
                    <li>
                        <a href="#"><i class="icon-align-center" title="align-center"></i></a>
                    </li>

                    <li >
                        <a href="#"><i class="icon icon-align-justify" title="align-justify"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-align-left" title="align-left"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-align-right" title="align-right"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-down" title="arrow-down"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-left" title="arrow-left"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-thin-down" title="arrow-thin-down"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-right" title="arrow-right"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-thin-left" title="arrow-thin-left"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-thin-up" title="arrow-thin-up"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-up" title="arrow-up"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-attachment" title="attachment"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-arrow-thin-right" title="arrow-thin-right"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-code" title="code"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-cloud" title="cloud"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-chevron-right" title="chevron-right"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-chevron-up" title="chevron-up"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-chevron-down" title="chevron-down"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-chevron-left" title="chevron-left"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-camera" title="camera"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-checkmark" title="checkmark"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-calendar" title="calendar"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-clockwise" title="clockwise"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-conversation" title="conversation"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-direction" title="direction"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-cross" title="cross"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-graph-line" title="graph-line"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-gear" title="gear"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-graph-bar" title="graph-bar"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-export" title="export"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-feed" title="feed"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-folder" title="folder"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-forward" title="forward"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-folder-open" title="folder-open"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-download" title="download"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-document-new" title="document-new"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-document-edit" title="document-edit"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-document" title="document"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-gaming" title="gaming"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-graph-pie" title="graph-pie"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-heart" title="heart"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-headset" title="headset"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-help" title="help"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-information" title="information"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-loading" title="loading"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-lock" title="lock"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-location" title="location"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-lock-open" title="lock-open"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-mail" title="mail"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-map" title="map"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-loop" title="media-loop"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-mobile-portrait" title="mobile-portrait"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-mobile-landscape" title="mobile-landscape"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-microphone" title="microphone"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-minus" title="minus"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-message" title="message"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-menu" title="menu"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-stop" title="media-stop"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-shuffle" title="media-shuffle"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-previous" title="media-previous"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-play" title="media-play"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-next" title="media-next"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-pause" title="media-pause"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-monitor" title="monitor"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-move" title="move"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-plus" title="plus"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-phone" title="phone"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-preview" title="preview"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-print" title="print"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-media-record" title="media-record"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-music" title="music"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-home" title="home"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-question" title="question"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-reply" title="reply"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-reply-all" title="reply-all"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-return" title="return"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-retweet" title="retweet"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-search" title="search"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-view-thumb" title="view-thumb"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-view-list-large" title="view-list-large"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-view-list" title="view-list"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-upload" title="upload"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-user-group" title="user-group"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-trash" title="trash"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-user" title="user"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-thumbs-up" title="thumbs-up"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-thumbs-down" title="thumbs-down"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-tablet-portrait" title="tablet-portrait"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-tablet-landscape" title="tablet-landscape"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-tag" title="tag"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-star" title="star"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-volume-full" title="volume-full"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-volume-off" title="volume-off"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-warning" title="warning"></i></a>
                    </li>
                    <li >
                        <a href="#"><i class="icon icon-window" title="window"></i></a>
                    </li>
                </ul>
            </div>
        </section>
    </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>

    <script type="text/javascript">
    $(document).ready (function () {
        $('.icon-packs a').each(function () {
            var $element     = $(this);
            $element.click(function (evt) {
                var class_name  = evt.target.classList.toString();
                $('input:text[name="icon"]').val(class_name);
                $('#menusModal').modal('hide');
                evt.preventDefault();
            });
        })
    });
    </script>
@stop