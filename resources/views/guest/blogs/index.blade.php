<x-app-layout>
    {{-- Hero --}}
    <section class="bg-[#0A1628] py-16 px-6">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span
                class="inline-block bg-blue-600/20 text-blue-400 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest border border-blue-600/30">
                Blog & Artikel
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-white leading-tight">
                Tips, Panduan & Inspirasi<br>untuk Event Creator
            </h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                Temukan artikel terbaik seputar dunia event, ticketing, dan marketing untuk bantu kamu sukses.
            </p>

            {{-- Search --}}
            <form action="{{ route('blog.index') }}" method="GET" class="max-w-lg mx-auto pt-4">
                <div
                    class="flex items-center bg-white/10 border border-white/20 rounded-2xl overflow-hidden backdrop-blur">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..."
                        class="flex-1 bg-transparent text-white placeholder-slate-400 px-5 py-3.5 outline-none text-sm font-medium">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3.5 font-bold text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 py-12 space-y-12">

        {{-- Featured Blogs --}}
        @if ($featuredBlogs->count() > 0 && !request('search') && !request('category'))
            <section class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-6 bg-blue-600 rounded-full"></div>
                    <h2 class="text-xl font-black text-slate-800">Artikel Terpopuler</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($featuredBlogs as $index => $featured)
                        <a href="{{ route('blog.show', $featured->slug) }}"
                            class="group relative rounded-2xl overflow-hidden shadow-sm border border-gray-100 {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                            <div
                                class="{{ $index === 0 ? 'h-72' : 'h-48' }} bg-gradient-to-br
                                {{ $index === 0 ? 'from-blue-600 to-indigo-700' : ($index === 1 ? 'from-purple-500 to-pink-600' : 'from-orange-400 to-red-500') }}
                                relative overflow-hidden">
                                @if ($featured->thumbnail)
                                    <img src="{{ asset('storage/' . $featured->thumbnail) }}"
                                        alt="{{ $featured->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center opacity-20">
                                        <i class="fas fa-newspaper text-white text-8xl"></i>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    @if ($featured->category)
                                        <span
                                            class="inline-block bg-white/20 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-2">
                                            {{ $featured->category }}
                                        </span>
                                    @endif
                                    <h3
                                        class="text-white font-black {{ $index === 0 ? 'text-xl' : 'text-sm' }} leading-snug line-clamp-2">
                                        {{ $featured->title }}
                                    </h3>
                                    <div class="flex items-center gap-3 mt-2 text-white/60 text-xs">
                                        <span>{{ $featured->published_at?->translatedFormat('j M Y') }}</span>
                                        <span>•</span>
                                        <span><i
                                                class="fas fa-eye mr-1"></i>{{ number_format($featured->views) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Filter Kategori --}}
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('blog.index', request()->except('category')) }}"
                class="px-4 py-2 rounded-xl text-sm font-bold transition-all
                    {{ !request('category') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white text-slate-600 border border-gray-200 hover:border-blue-300' }}">
                Semua
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('blog.index', array_merge(request()->except('category'), ['category' => $cat])) }}"
                    class="px-4 py-2 rounded-xl text-sm font-bold transition-all
                        {{ request('category') === $cat ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white text-slate-600 border border-gray-200 hover:border-blue-300' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- Info hasil --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500 font-medium">
                Menampilkan <span class="font-bold text-slate-800">{{ $blogs->total() }}</span> artikel
                @if (request('search'))
                    untuk "<span class="font-bold text-blue-600">{{ request('search') }}</span>"
                @endif
            </p>
            @if (request('search') || request('category'))
                <a href="{{ route('blog.index') }}"
                    class="text-sm font-bold text-red-500 hover:text-red-700 flex items-center gap-1">
                    <i class="fas fa-times"></i> Reset Filter
                </a>
            @endif
        </div>

        {{-- Grid Blog --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($blogs as $blog)
                <a href="{{ route('blog.show', $blog->slug) }}"
                    class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">

                    {{-- Thumbnail --}}
                    <div
                        class="h-48 relative overflow-hidden bg-gradient-to-br
                        {{ collect(['from-blue-500 to-indigo-600', 'from-purple-500 to-pink-600', 'from-orange-400 to-red-500', 'from-green-400 to-teal-600', 'from-yellow-400 to-orange-500'])->random() }}">
                        @if ($blog->thumbnail)
                            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center opacity-20">
                                <i class="fas fa-newspaper text-white text-6xl"></i>
                            </div>
                        @endif
                        @if ($blog->category)
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/90 backdrop-blur text-slate-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                                    {{ $blog->category }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-5 flex flex-col flex-1 space-y-3">
                        <h3
                            class="font-black text-slate-800 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                            {{ $blog->title }}
                        </h3>

                        @if ($blog->excerpt)
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2">
                                {{ $blog->excerpt }}
                            </p>
                        @endif

                        <div class="mt-auto pt-3 border-t border-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                    {{ strtoupper(substr($blog->author->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-600">{{ $blog->author->name }}</p>
                                    <p class="text-[10px] text-slate-400">
                                        {{ $blog->published_at?->translatedFormat('j M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-slate-400 text-xs">
                                <i class="fas fa-eye"></i>
                                <span>{{ number_format($blog->views) }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-20 text-slate-400">
                    <i class="fas fa-newspaper text-5xl mb-4 block opacity-20"></i>
                    <p class="font-bold text-lg">Belum ada artikel</p>
                    <p class="text-sm mt-1">Coba ubah kata kunci atau kategori</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($blogs->hasPages())
            <div class="flex justify-center">
                {{ $blogs->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
