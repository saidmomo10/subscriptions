<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            'name' => $request->input('name'),
            'duration' => $request->input('duration'),
        ]);
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
        return view('subscriptionsViews.showSubscription', compact('subscription'));
    }

    public function activate($id)
    {
        $subscription = Subscription::findOrFail($id);

        // Vérifier si l'abonnement est déjà activé
        if ($subscription->start_date <= now() && $subscription->end_date >= now()) {
            return back()->with('message', 'Cet abonnement est déjà actif.');
        }

        // Activer l'abonnement en mettant à jour les dates
        $subscription->start_date = now();
        $subscription->end_date = now()->addDays($subscription->duration); // ou utilisez la logique appropriée
        $subscription->save();

        return redirect()->route('dashboard')->with('success', 'Abonnement activé avec succès!');
    }
}