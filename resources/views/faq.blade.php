@extends('layouts.front.master')

@section('page')
    FAQ
@endsection

@push('css')
    
@endpush

@section('content')
<section class="faq_area pt-40 pb-120 mb-120" id="faq">
    <div class="container pt-60">
        <div class="faq-heading pb-20">
            <h1>Frequently Asked Questions</h1>
        </div>
        <details>
            <summary>How do I place an ad?</summary>
            <div class="faq__content">
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem incidunt laborum necessitatibus
                    perferendis possimus quasi similique suscipit tempora ullam voluptas. Amet blanditiis ducimus illum
                    numquam sequi ut veniam? Cum, laborum.
                </p>
            </div>
        </details>

        <details>
            <summary>Who should I contact, if I have any problem?</summary>
            <div class="faq__content">
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, consequuntur cupiditate,
                    deserunt doloribus earum hic id impedit in ipsum iste nesciunt officiis quibusdam repellat
                    repudiandae, sapiente sequi sunt voluptatem voluptatibus?
                </p>
            </div>
        </details>
        <details>
            <summary>How can I cancel or change my order?</summary>
            <div class="faq__content">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, blanditiis corporis eaque
                    impedit ipsam minus numquam quam ratione. Architecto aspernatur assumenda iste odit, officiis ut
                    vel! Itaque libero quam similique?
                </p>
            </div>
        </details>
        <details>
            <summary>How can I return a product?</summary>
            <div class="faq__content">
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, aliquid amet at consectetur corporis,
                    dolor dolore eos fuga illum impedit iure nam porro quae rem similique sint unde veniam voluptatum!
                </p>
            </div>
        </details>
        <details>
            <summary>How long will it take to get my package?</summary>
            <div class="faq__content">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, blanditiis corporis eaque
                    impedit ipsam minus numquam quam ratione. Architecto aspernatur assumenda iste odit, officiis ut
                    vel! Itaque libero quam similique?
                </p>
            </div>
        </details>
    </div>
</section>

<br/>
@endsection

@push('js')
    
@endpush