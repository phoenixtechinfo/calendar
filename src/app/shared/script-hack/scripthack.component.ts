import { Component, ElementRef, ViewChild, Input } from '@angular/core';

@Component({
    selector: 'script-hack',
    templateUrl: './scripthack.component.html'
})
export class ScriptHackComponent {

    @Input()
    src: string;

    @Input()
    agentEmail: string;

    @Input()
    displayType: string;

    @Input()
    featuredPackages: string;

    @Input()
    type: string;

    @ViewChild('script') script: ElementRef;

    constructor(private elRef: ElementRef){}

    convertToScript() {
        var element = this.script.nativeElement;
        var script = document.createElement("script");
        script.type = this.type ? this.type : "text/javascript";
        script.setAttribute('agent-email', this.agentEmail);
        script.setAttribute('display-type', this.displayType);
        script.setAttribute('featured-packages', this.featuredPackages);
        if (this.src) {
            script.src = this.src;
        }
        if (element.innerHTML) {
            script.innerHTML = element.innerHTML;
        }
        var parent = element.parentElement;
        parent.parentElement.replaceChild(script, parent);
    }

    ngAfterViewInit() {
        this.convertToScript();
    }
}