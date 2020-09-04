document.addEventListener('readystatechange', event => { 
    // When window loaded ( external resources are loaded too- `css`,`src`, etc...) 
    if (event.target.readyState === "complete") {
        window.livewire.restart()
    }
});

document.addEventListener("DOMContentLoaded", function(event) {
    document.querySelectorAll('[wire\\:id]').forEach(function(el) {
        const component = el.__livewire;
        const dataObject = {
            data: component.data,
            events: component.events,
            children: component.children,
            checksum: component.checksum,
            name: component.name,
            errorBag: component.errorBag,
            redirectTo: component.redirectTo,
        };
        el.setAttribute('wire:initial-data', JSON.stringify(dataObject));
    });
});