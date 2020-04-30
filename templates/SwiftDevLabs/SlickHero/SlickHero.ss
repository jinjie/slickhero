<% if $Banners %>
<div class="slickhero" id="slickhero-{$ID}">
    <% loop $Banners %>
        <% include SwiftDevLabs\\SlickHero\\Banner %>
    <% end_loop %>
</div>
<% end_if %>
