<?php

function head_code()
{
    if (ads('head_code') && uploadSettings()->upload->advertisements) {
        return ads('head_code')->code;
    }
}

function ads_home_page_top()
{
    if (ads('home_page_top') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mt-80">' . ads('home_page_top')->code . '</div>
        </center>';
    }
}

function ads_home_page_center()
{
    if (ads('home_page_center') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mt-80">' . ads('home_page_center')->code . '</div>
        </center>';
    }
}

function ads_home_page_bottom()
{
    if (ads('home_page_bottom') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mb-80">' . ads('home_page_bottom')->code . '</div>
        </center>';
    }
}

function ads_image_page_image_top()
{
    if (ads('image_page_image_top') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mb-40">' . ads('image_page_image_top')->code . '</div>
        </center>';
    }
}

function ads_image_page_image_bottom()
{
    if (ads('image_page_image_bottom') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mt-5">' . ads('image_page_image_bottom')->code . '</div>
        </center>';
    }
}

function ads_image_page_center()
{
    if (ads('image_page_center') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90">' . ads('image_page_center')->code . '</div>
        </center>';
    }
}

function ads_image_page_bottom()
{
    if (ads('image_page_bottom') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mb-80">' . ads('image_page_bottom')->code . '</div>
        </center>';
    }
}

function ads_blog_page_top()
{
    if (ads('blog_page_top') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mb-5">' . ads('blog_page_top')->code . '</div>
        </center>';
    }
}

function ads_blog_page_bottom()
{
    if (ads('blog_page_bottom') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mt-5">' . ads('blog_page_bottom')->code . '</div>
        </center>';
    }
}

function ads_blog_page_sidebar_top()
{
    if (ads('blog_page_sidebar_top') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-300x280 mb-4">' . ads('blog_page_sidebar_top')->code . '</div>
        </center>';
    }
}

function ads_blog_page_article_top()
{
    if (ads('blog_page_article_top') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90 mb-3">' . ads('blog_page_article_top')->code . '</div>
        </center>';
    }
}

function ads_blog_page_article_Bottom()
{
    if (ads('blog_page_article_Bottom') && uploadSettings()->upload->advertisements) {
        return '<center>
           <div class="vr-adv-unit vr-adv-unit-728x90">' . ads('blog_page_article_Bottom')->code . '</div>
        </center>';
    }
}
