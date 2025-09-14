"use client";
import ArticleFacet from "./ArticleFacet";

export default function ExhaustFanFacet() {
  const category = process.env.NEXT_PUBLIC_EXHAUST_FAN_CATEGORY_ID || "";
  return (
    <ArticleFacet
      category={category}
      selectionKey="exhaustFan"
      title="Abluft Ventilator"
      queryKey={["exhaustFanArticles"]}
    />
  );
}
