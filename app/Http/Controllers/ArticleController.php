<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::paginate(10);

        return view('admin.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $article = new Article();
        return view('admin.articles.form', [
            'article' => $article,
            'action' => route('admin.articles.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $article = Article::create($this->extracteData(new Article(), $request));

        return redirect()->route('admin.articles.edit', $article)->with('success', 'L\'article a bien été sauvegardé');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.form', [
            'article' => $article,
            'action' => route('admin.articles.update', $article)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {

        $article->update($this->extracteData($article, $request));

        return redirect()->route('admin.articles.index')->with('success', "L'article a bien été modifié");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->deleteImage($article);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', "L'article a bien été supprimé");
    }

    private function extracteData (Article $article, ArticleRequest $request): array
    {
        $data = $request->validated();
        /** @var UploadedFile|null $image */
        $image = $request->validated('image');
        if ($image === null || $image->getError()) {
            return $data;
        }
        $this->deleteImage($article);
        $data['image'] = $image->store('article', 'public');

        return $data;
    }

    private function deleteImage(Article $article): void
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
    }
}
