@extends('layouts.blank')
@extends('layouts.blank')
@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('/css/dripicon.css') }}">
@stop
@section('content')
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="menuLabelModal">Select Parent Menu</h4>
    </div>
    <div class="modal-body">
        <section data-valign="center" data-cols="1" data-name="preview">
            <div class="entypo-tooltip">
                <ul>
                    <li class="icon-align-center" title="align-center"></li>

                    <li class="icon icon-align-justify" title="align-justify">
                    </li>
                    <li class="icon icon-align-left" title="align-left">
                    </li>
                    <li class="icon icon-align-right" title="align-right">
                    </li>
                    <li class="icon icon-arrow-down" title="arrow-down">
                    </li>
                    <li class="icon icon-arrow-left" title="arrow-left">
                    </li>
                    <li class="icon icon-arrow-thin-down" title="arrow-thin-down">
                    </li>
                    <li class="icon icon-arrow-right" title="arrow-right">
                    </li>
                    <li class="icon icon-arrow-thin-left" title="arrow-thin-left">
                    </li>
                    <li class="icon icon-arrow-thin-up" title="arrow-thin-up">
                    </li>
                    <li class="icon icon-arrow-up" title="arrow-up">
                    </li>
                    <li class="icon icon-attachment" title="attachment">
                    </li>
                    <li class="icon icon-arrow-thin-right" title="arrow-thin-right">
                    </li>
                    <li class="icon icon-code" title="code">
                    </li>
                    <li class="icon icon-cloud" title="cloud">
                    </li>
                    <li class="icon icon-chevron-right" title="chevron-right">
                    </li>
                    <li class="icon icon-chevron-up" title="chevron-up">
                    </li>
                    <li class="icon icon-chevron-down" title="chevron-down">
                    </li>
                    <li class="icon icon-chevron-left" title="chevron-left">
                    </li>
                    <li class="icon icon-camera" title="camera">
                    </li>
                    <li class="icon icon-checkmark" title="checkmark">
                    </li>
                    <li class="icon icon-calendar" title="calendar">
                    </li>
                    <li class="icon icon-clockwise" title="clockwise">
                    </li>
                    <li class="icon icon-conversation" title="conversation">
                    </li>
                    <li class="icon icon-direction" title="direction">
                    </li>
                    <li class="icon icon-cross" title="cross">
                    </li>
                    <li class="icon icon-graph-line" title="graph-line">
                    </li>
                    <li class="icon icon-gear" title="gear">
                    </li>
                    <li class="icon icon-graph-bar" title="graph-bar">
                    </li>
                    <li class="icon icon-export" title="export">
                    </li>
                    <li class="icon icon-feed" title="feed">
                    </li>
                    <li class="icon icon-folder" title="folder">
                    </li>
                    <li class="icon icon-forward" title="forward">
                    </li>
                    <li class="icon icon-folder-open" title="folder-open">
                    </li>
                    <li class="icon icon-download" title="download">
                    </li>
                    <li class="icon icon-document-new" title="document-new">
                    </li>
                    <li class="icon icon-document-edit" title="document-edit">
                    </li>
                    <li class="icon icon-document" title="document">
                    </li>
                    <li class="icon icon-gaming" title="gaming">
                    </li>
                    <li class="icon icon-graph-pie" title="graph-pie">
                    </li>
                    <li class="icon icon-heart" title="heart">
                    </li>
                    <li class="icon icon-headset" title="headset">
                    </li>
                    <li class="icon icon-help" title="help">
                    </li>
                    <li class="icon icon-information" title="information">
                    </li>
                    <li class="icon icon-loading" title="loading">
                    </li>
                    <li class="icon icon-lock" title="lock">
                    </li>
                    <li class="icon icon-location" title="location">
                    </li>
                    <li class="icon icon-lock-open" title="lock-open">
                    </li>
                    <li class="icon icon-mail" title="mail">
                    </li>
                    <li class="icon icon-map" title="map">
                    </li>
                    <li class="icon icon-media-loop" title="media-loop">
                    </li>
                    <li class="icon icon-mobile-portrait" title="mobile-portrait">
                    </li>
                    <li class="icon icon-mobile-landscape" title="mobile-landscape">
                    </li>
                    <li class="icon icon-microphone" title="microphone">
                    </li>
                    <li class="icon icon-minus" title="minus">
                    </li>
                    <li class="icon icon-message" title="message">
                    </li>
                    <li class="icon icon-menu" title="menu">
                    </li>
                    <li class="icon icon-media-stop" title="media-stop">
                    </li>
                    <li class="icon icon-media-shuffle" title="media-shuffle">
                    </li>
                    <li class="icon icon-media-previous" title="media-previous">
                    </li>
                    <li class="icon icon-media-play" title="media-play">
                    </li>
                    <li class="icon icon-media-next" title="media-next">
                    </li>
                    <li class="icon icon-media-pause" title="media-pause">
                    </li>
                    <li class="icon icon-monitor" title="monitor">
                    </li>
                    <li class="icon icon-move" title="move">
                    </li>
                    <li class="icon icon-plus" title="plus">
                    </li>
                    <li class="icon icon-phone" title="phone">
                    </li>
                    <li class="icon icon-preview" title="preview">
                    </li>
                    <li class="icon icon-print" title="print">
                    </li>
                    <li class="icon icon-media-record" title="media-record">
                    </li>
                    <li class="icon icon-music" title="music">
                    </li>
                    <li class="icon icon-home" title="home">
                    </li>
                    <li class="icon icon-question" title="question">
                    </li>
                    <li class="icon icon-reply" title="reply">
                    </li>
                    <li class="icon icon-reply-all" title="reply-all">
                    </li>
                    <li class="icon icon-return" title="return">
                    </li>
                    <li class="icon icon-retweet" title="retweet">
                    </li>
                    <li class="icon icon-search" title="search">
                    </li>
                    <li class="icon icon-view-thumb" title="view-thumb">
                    </li>
                    <li class="icon icon-view-list-large" title="view-list-large">
                    </li>
                    <li class="icon icon-view-list" title="view-list">
                    </li>
                    <li class="icon icon-upload" title="upload">
                    </li>
                    <li class="icon icon-user-group" title="user-group">
                    </li>
                    <li class="icon icon-trash" title="trash">
                    </li>
                    <li class="icon icon-user" title="user">
                    </li>
                    <li class="icon icon-thumbs-up" title="thumbs-up">
                    </li>
                    <li class="icon icon-thumbs-down" title="thumbs-down">
                    </li>
                    <li class="icon icon-tablet-portrait" title="tablet-portrait">
                    </li>
                    <li class="icon icon-tablet-landscape" title="tablet-landscape">
                    </li>
                    <li class="icon icon-tag" title="tag">
                    </li>
                    <li class="icon icon-star" title="star">
                    </li>
                    <li class="icon icon-volume-full" title="volume-full">
                    </li>
                    <li class="icon icon-volume-off" title="volume-off">
                    </li>
                    <li class="icon icon-warning" title="warning">
                    </li>
                    <li class="icon icon-window" title="window">
                    </li>

                </ul>
            </div>
        </section>
    </div>
@stop