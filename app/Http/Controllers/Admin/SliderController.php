<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::ordered()->paginate(12);
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Déterminer l'ordre suivant
        $nextOrder = Slider::max('order') + 1;
        return view('admin.sliders.create', compact('nextOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:1',
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'subtitle.max' => 'Le sous-titre ne peut pas dépasser 500 caractères.',
            'image.required' => 'Une image est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WebP.',
            'image.max' => 'L\'image ne peut pas dépasser 5 Mo.',
            'button_text.max' => 'Le texte du bouton ne peut pas dépasser 100 caractères.',
            'button_link.url' => 'Le lien du bouton doit être une URL valide.',
            'order.required' => 'L\'ordre est obligatoire.',
            'order.min' => 'L\'ordre doit être au minimum 1.',
        ]);

        // Préparer les données
        $data = $request->only(['title', 'subtitle', 'button_text', 'button_link', 'order']);
        $data['is_active'] = $request->has('is_active');

        // Gérer l'upload d'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            // Créer le dossier s'il n'existe pas
            $uploadPath = public_path('images/sliders');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Déplacer l'image
            $image->move($uploadPath, $imageName);
            $data['image'] = 'images/sliders/' . $imageName;
        }

        // Créer le slider
        $slider = Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider "' . $slider->title . '" créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:1',
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'subtitle.max' => 'Le sous-titre ne peut pas dépasser 500 caractères.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WebP.',
            'image.max' => 'L\'image ne peut pas dépasser 5 Mo.',
            'button_text.max' => 'Le texte du bouton ne peut pas dépasser 100 caractères.',
            'button_link.url' => 'Le lien du bouton doit être une URL valide.',
            'order.required' => 'L\'ordre est obligatoire.',
            'order.min' => 'L\'ordre doit être au minimum 1.',
        ]);

        // Préparer les données
        $data = $request->only(['title', 'subtitle', 'button_text', 'button_link', 'order']);
        $data['is_active'] = $request->has('is_active');

        // Gestion de la nouvelle image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Supprimer l'ancienne image
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }
            
            // Nettoyer Media Library
            $slider->clearMediaCollection('banners');
            
            // Upload nouvelle image - stockage direct uniquement
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            $uploadPath = public_path('images/sliders');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Déplacer le fichier vers le stockage public
            $image->move($uploadPath, $imageName);
            $data['image'] = 'images/sliders/' . $imageName;
        }

        // Mettre à jour le slider
        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider "' . $slider->title . '" modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $sliderTitle = $slider->title;
        
        // Supprimer l'image du stockage direct
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }
        
        // Supprimer de Media Library
        $slider->clearMediaCollection('banners');
        
        // Supprimer le slider
        $slider->delete();
        
        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider "' . $sliderTitle . '" supprimé avec succès !');
    }

    /**
     * Toggle the status of a slider.
     */
    public function toggleStatus(Request $request, Slider $slider)
    {
        $slider->update(['is_active' => $request->boolean('is_active')]);
        
        $status = $slider->is_active ? 'activé' : 'désactivé';
        
        return response()->json([
            'success' => true,
            'message' => "Slider \"{$slider->title}\" {$status} avec succès.",
            'status' => $slider->is_active
        ]);
    }

    /**
     * Get slider preview data.
     */
    public function preview(Slider $slider)
    {
        return response()->json([
            'id' => $slider->id,
            'title' => $slider->title,
            'subtitle' => $slider->subtitle,
            'button_text' => $slider->button_text,
            'button_link' => $slider->button_link,
            'image' => $this->getSliderImageUrl($slider),
            'is_active' => $slider->is_active,
            'order' => $slider->order
        ]);
    }

    /**
     * Update slider order.
     */
    public function updateOrder(Request $request, Slider $slider)
    {
        $request->validate([
            'order' => 'required|integer|min:1'
        ]);

        $slider->update(['order' => $request->order]);

        return response()->json([
            'success' => true,
            'message' => 'Ordre du slider mis à jour avec succès.'
        ]);
    }

    /**
     * Reorder all sliders.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'sliders' => 'required|array',
            'sliders.*.id' => 'required|exists:sliders,id',
            'sliders.*.order' => 'required|integer|min:1'
        ]);

        foreach ($request->sliders as $sliderData) {
            Slider::where('id', $sliderData['id'])
                  ->update(['order' => $sliderData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordre des sliders mis à jour avec succès.'
        ]);
    }

    /**
     * Get the image URL for a slider (stockage direct).
     */
    private function getSliderImageUrl(Slider $slider): ?string
    {
        // Stockage direct
        if ($slider->image) {
            return asset($slider->image);
        }
        
        return null;
    }

    /**
     * Bulk actions on sliders.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'slider_ids' => 'required|array',
            'slider_ids.*' => 'exists:sliders,id'
        ]);

        $sliders = Slider::whereIn('id', $request->slider_ids);
        $count = $sliders->count();

        switch ($request->action) {
            case 'activate':
                $sliders->update(['is_active' => true]);
                $message = "{$count} slider(s) activé(s) avec succès.";
                break;
                
            case 'deactivate':
                $sliders->update(['is_active' => false]);
                $message = "{$count} slider(s) désactivé(s) avec succès.";
                break;
                
            case 'delete':
                // Supprimer les images avant de supprimer les sliders
                foreach ($sliders->get() as $slider) {
                    if ($slider->image && file_exists(public_path($slider->image))) {
                        unlink(public_path($slider->image));
                    }
                    $slider->clearMediaCollection('banners');
                }
                $sliders->delete();
                $message = "{$count} slider(s) supprimé(s) avec succès.";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
