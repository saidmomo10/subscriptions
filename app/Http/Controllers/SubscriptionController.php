<?php

namespace App\Http\Controllers;

use App\Models\File;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubscriptionController extends Controller
{
    public function addSubscriptions()
    {
        return view('subscriptionsViews.addSubscriptions');
    }

    public function createSubscription(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
        ]);

        // Créer un nouvel abonnement
        $subscription = new Subscription([
            // 'user_id' => auth()->user()->id,
            // 'start_date' => now(),
            'name' => $request->input('name'),
            'duration' => $request->input('duration'),
        ]);
        // $subscription->update(['start_date'=> now()]);
        $subscription->save();

        return back()->with('message', 'Abonnement créé avec succès!');
    }

    public function list()
    {
        $subscriptions = Subscription::all();
        return view('subscriptionsViews.subscriptionsListView', compact('subscriptions'));
    }

    public function show($id){
        $subscription = Subscription::find($id);
        $user = Auth::user();
        $files = File::all();

        $attachedChannels = $subscription->files()->pluck('files.id')->toArray();
        $availableChannels = $files->whereNotIn('id', $attachedChannels);
    
        $chaine = $subscription->files()->get();
        // dd($chaine);
        $key = $user->subscriptions()->latest('activated_at')->first();
        // dd($key->pivot->status);
        if ($key != null && $key->pivot->end_date <= now()) {
            $key->pivot->status = 'Abonnement expire';           
            $key->pivot->save();
        }else if($key != null){
            $key->pivot->status = 'Abonnement actif'; 
            $key->pivot->save();
        }
        
        // $subscription->save();
        // dd($subscription);
        return view('subscriptionsViews.showSubscription', compact('subscription','user','key','files', 'chaine', 'availableChannels'));
    }

    public function activate($id)
    {
        $user = auth()->user();
        // dd($user);
    //     if (!$user) {
    //     return back()->with('message', 'Utilisateur non trouvé.');
    // }
        $subscription = Subscription::findOrFail($id);

        // Vérifier si l'abonnement est déjà activé
        // if ($subscription->end_date >= now()) {
        //     return back()->with('message', 'Cet abonnement est déjà actif.');
        // }

        // if($user->subscriptions()->where('subscription_id', $subscription->id)->exists()){
        //     return back()->with('message', 'Cet abonnement est déjà actif.');
        // }

        // $subscription->status = 'Abonnement actif';

        // Activer l'abonnement en mettant à jour les dates
        // $subscription->user_id = auth()->user()->id;
        $user->subscriptions()->attach($subscription->id,['activated_at' => now(), 'status' => 'Abonnement actif', 'end_date' => now()->addMinutes($subscription->duration)]);
        // $subscription->start_date = now();
        // $subscription->end_date = now()->addMinutes($subscription->duration); // ou utilisez la logique appropriée
        $subscription->save();
        // $this->status($subscriptions);
        

        return back()->with('success', 'Abonnement activé avec succès!');
    }

    // public function status($id)
    // {
    //     $subscriptions = Subscription::findOrFail($id);

    //     // Vérifier si l'abonnement est déjà activé
    //     if ($subscriptions->end_date <= now()) {
    //         $subscriptions->status = 'Abonnement non actif'; 
    //         $subscriptions->save();
    //     }else{
    //         $subscriptions->status = 'Abonnement actif'; 
    //         $subscriptions->save();
    //     }
        
    //     $subscriptions->save();
    //     dd($subscriptions);
    //     return back();
    // }

        public function affect($id){
            $subscription = Subscription::findOrFail($id);
            // $file = File::findOrfail($id);
            $fileIds = request('file_ids');

            // $file->subscriptions()->attach($subscription->id);

            $subscription->files()->attach($fileIds);
        //     if($subscription->files()->where('file_id', $file->id)->exists()){
        //     return back()->with('message', 'Cet abonnement est déjà actif.');
        // }
            
            // $subscription->save();
            
            return back()->with('success', 'Chaine affecté avec succès!');
        }
}