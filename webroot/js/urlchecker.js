//highlight.js init for HTML syntax highlighting
hljs.initHighlightingOnLoad();
$( document ).ready(function() {
    
    $("#url-form").submit(function(event) {
        var $this = $(this);
        $.post($this.rel, $this.serialize(), function(response) {
            
            
            //load html into div and syntax highlight
            var $responseContainer = $( ".response > .container-fluid");
            $responseContainer.height($(window).height() - 70);
            $responseContainer.html( "<pre><code class=\"html\">" + response.html + "</code></pre>");
            
            //color syntax in the html source
            hljs.highlightBlock($('code', $responseContainer)[0]);
            
            
            //add tag types to the highlight.js tags so they can be highlighted quickly.
            addTagToClass();
            
            //setup tags and counts in fixed table overlay
            addTagsToTable(response.tagCount);
            
            //setup hover listener for table rows
            highlightOnHover();
    
        });
        //never regularly submit the form
        event.preventDefault();
    });
});

//take each html tag located inside of the hljs-tag spans and add the tag name to the class
function addTagToClass() {
    $("span.hljs-tag").each(function(index, element) {
        $element = $(element);
        var className = $element.text().match( /<\/?([a-zA-Z]+)/);
        $element.addClass(className[1]);
    });
}

//highlight the tags when they are hovered over
function highlightOnHover() {
    var tag;
    $(".tagListItem").hover( function() {
        tag = $(this).data('tag');
        $("span."+tag+", span."+tag+" .hljs-name").addClass("highlight");
        
    }, function() {
        $("span."+tag+", span."+tag+" .hljs-name").removeClass("highlight");
    });
}

//take the tags and their counts and create a table with them
function addTagsToTable(tags) {
    console.log(tags);
    var $table = $("table.tags > tbody");
    $table.empty();
    
    var header = $('<tr>');
    header.append($('<th>').text("Tags"));
    header.append($('<th>').text("Counts"));
    $table.append(header);
    
    //tags is an object so we'll count the number of tags in the loop
    var numOfTags = 0;
    $.each(tags, function(tag, tagCount) {
      
      numOfTags++;
      
      tag = tag.toLowerCase();  
      var row = $('<tr>',
        {
            class: 'tagListItem',
            "data-tag": tag
        });
      row.append($('<td>').text(tag));
      row.append($('<td>').text(tagCount));
      $table.append(row);
    });

    //more than 5 tags, fix the hight of the box to a third of the window
    if (numOfTags > 5) {
        $(".tag-scrollbox").height($(window).height() / 3);
    }
    
    $(".tag-scrollbox").show();
    
}