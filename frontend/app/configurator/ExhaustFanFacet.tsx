"use client";
import ArticleFacet from "./ArticleFacet";

export default function ExhaustFanFacet() {
  return (
    <ArticleFacet
      category="exhaust-fan"
      selectionKey="exhaustFan"
      title="Abluft Ventilator"
      queryKey={["exhaustFanArticles"]}
    />
  );
}
