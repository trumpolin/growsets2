import { FacetPanelGroup } from "@/components/FacetPanel";
import CategoryPanel from "@/components/CategoryPanel";

export default function Home() {
  return (
    <>
      <section className="bg-primary text-white py-18">
        <div className="container mx-auto px-4 text-center">
          <h1 className="mb-4 text-4xl font-display">Growsets</h1>
          <p className="mx-auto mb-8 max-w-2xl text-lg">
            Growsets ist ein Projekt, das dir hilft, die passende Kombination
            aus Growbox, Beleuchtung und Belüftung zu finden.
          </p>
          <a
            href="configurator"
            className="inline-block rounded bg-secondary px-6 py-3 font-semibold text-white hover:bg-accent"
          >
            Zum Konfigurator
          </a>
        </div>
      </section>

      <section className="container mx-auto my-18 px-4">
        <h2 className="mb-4 text-2xl font-semibold text-primary">Produkte</h2>
        <FacetPanelGroup>
          <CategoryPanel category="growbox" title="Growbox" />
          <CategoryPanel category="growled" title="Grow LED" />
          <CategoryPanel
            category="abluft-ventilator"
            title="Abluft Ventilator"
          />
          <CategoryPanel category="aktivkohlefilter" title="Aktivkohlefilter" />
          <CategoryPanel category="abluftschlauch" title="Abluftschlauch" />
          <CategoryPanel category="umluftventilator" title="Umluftventilator" />
          <CategoryPanel category="controller" title="Controller" />
        </FacetPanelGroup>
      </section>
    </>
  );
}
