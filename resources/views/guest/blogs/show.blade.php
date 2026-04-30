<x-app-layout>
    <div class="bg-slate-50 min-h-screen">

        {{-- Hero --}}
        <div class="bg-[#0A1628] py-16 px-6">
            <div class="max-w-4xl mx-auto space-y-6">
                @if ($blog->category)
                    <span
                        class="inline-block bg-blue-600/20 text-blue-400 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest border border-blue-600/30">
                        {{ $blog->category }}
                    </span>
                @endif

                <h1 class="text-3xl md:text-4xl font-black text-white leading-tight">
                    {{ $blog->title }}
                </h1>

                <div class="flex items-center gap-6 text-sm text-slate-400">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr($blog->author->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-slate-300">{{ $blog->author->name }}</span>
                    </div>
                    <span>•</span>
                    <span>{{ $blog->published_at?->translatedFormat('j M Y') }}</span>
                    <span>•</span>
                    <span><i class="fas fa-eye mr-1"></i>{{ number_format($blog->views) }} views</span>
                </div>
            </div>
        </div>

        {{-- Thumbnail --}}
        @if ($blog->thumbnail)
            <div class="max-w-4xl mx-auto px-6 -mb-8 relative z-10 mt-6">
                <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                    class="w-full h-80 object-cover rounded-2xl shadow-xl">
            </div>
        @endif

        {{-- Konten --}}
        <div class="max-w-4xl mx-auto px-6 py-12 {{ $blog->thumbnail ? 'pt-20' : '' }}">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                {{-- Artikel --}}
                <article class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                        <div
                            class="prose prose-slate prose-lg max-w-none
                            prose-headings:font-black prose-headings:text-slate-800
                            prose-p:text-slate-600 prose-p:leading-relaxed
                            prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline
                            prose-strong:text-slate-800">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    {{-- Share --}}
                    <div class="mt-6 bg-white rounded-2xl border border-gray-100 p-6">
                        <p class="text-sm font-bold text-slate-600 mb-4">Bagikan artikel ini:</p>
                        <div class="flex items-center gap-3">
                            <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-bold">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-black text-white px-4 py-2 rounded-xl text-sm font-bold">
                                <i class="fab fa-x-twitter"></i> Twitter
                            </a>
                            <button onclick="navigator.clipboard.writeText(window.location.href)"
                                class="flex items-center gap-2 bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold">
                                <i class="far fa-copy"></i> Salin Link
                            </button>
                        </div>
                    </div>
                </article>

                {{-- Sidebar --}}
                <aside class="lg:col-span-4 space-y-6">

                    {{-- Info penulis --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center">
                        <div
                            class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-2xl font-black mx-auto mb-4">
                            {{ strtoupper(substr($blog->author->name, 0, 1)) }}
                        </div>
                        <p class="font-black text-slate-800">{{ $blog->author->name }}</p>
                        <p class="text-xs text-slate-400 mt-1">Penulis & Event Creator</p>
                    </div>

                    {{-- Artikel terkait --}}
                    @if ($relatedBlogs->count() > 0)
                        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
                            <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Artikel Terkait</h3>
                            <div class="space-y-4">
                                @foreach ($relatedBlogs as $related)
                                    <a href="{{ route('blog.show', $related->slug) }}" class="flex gap-4 group">
                                        <div
                                            class="w-16 h-16 rounded-xl flex-shrink-0 overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600">
                                            @if ($related->thumbnail)
                                                <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                                    class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-sm font-bold text-slate-700 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                                                {{ $related->title }}
                                            </p>
                                            <p class="text-xs text-slate-400 mt-1">
                                                {{ $related->published_at?->translatedFormat('j M Y') }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- CTA --}}
                    <div
                        class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white text-center space-y-3">
                        <i class="fas fa-rocket text-3xl"></i>
                        <p class="font-black text-lg leading-tight">Siap buat event kamu?</p>
                        <p class="text-blue-200 text-sm">Mulai buat event sekarang dan jangkau lebih banyak peserta.</p>
                        @auth
                            <a href="{{ route('creator.create') }}"
                                class="block bg-white text-blue-600 font-black py-3 rounded-xl text-sm">
                                Buat Event Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="block bg-white text-blue-600 font-black py-3 rounded-xl text-sm">
                                Buat Event Sekarang
                            </a>
                        @endauth

                    </div>

                </aside>
            </div>
        </div>

    </div>
</x-app-layout>
