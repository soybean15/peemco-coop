<div>
    <div id="editor-container" >
        <div id="editor-{{ $key }}">
            {!! html_entity_decode($value) !!}
        </div>
    </div>
</div>

<script>
     var editor = new Quill('#editor-{{ $key }}', {
      theme: 'snow',
      modules: {
          toolbar: [
              ['bold', 'italic', 'underline'],
              [{ 'header': 1 }, { 'header': 2 }],
              [{ 'list': 'ordered'}, { 'list': 'bullet' }],
             //   ['image', 'link'],
              ['align', { 'align': 'center' }],
              ['clean']
          ]
      }
    });
    editor.on('text-change', function () {
        // let value = document.getElementsByClassName('ql-editor')[0].innerHTML;
        let value = document.querySelector(`#editor-{{ $key }} .ql-editor`).innerHTML;

        console.log('{{ $model }}');//this displays the correct model but only update mission
        // let event = new Event('updated-editor', {detail: 'test'});
        // window.dispatchEvent(event);

        // Livewire.dispatch('updated-editor', {model:'{{ $model }}',value:value});


        @this.set('{{ $model }}', value);
    })


</script>
